<?php
namespace App;

use Predis\Client;
use App\Constants\Messages;
use App\Subscriber;

class MessageQueue implements Subscriber
{
    use SubscriberTrait;

    private string $id;

    private array $workers;

    private Client $redis;

    public function __construct(Client $redis) 
    {
        $this->id = 'queue_' . time();
        $this->redis = $redis;
    }

    public function channel(): string 
    {
        return $this->id;
    }

    public function open(...$workers): void
    {
        $redis = $this->redis;
        
        // Reset worker lists
        $channels = array_map(fn ($w) => $w->channel(), $workers);
        $redis->sinterstore($this->key('workers:working'), '[]');
        $redis->sadd($this->key('workers'), $channels);

        // Register workers
        $this->workers = $workers;

        array_walk($workers, fn($w) => $w->workFor($this));

        $this->subscribe($this->channel(), function ($json) use ($redis) {
            $payload = json_decode($json);
            switch ($payload['message']) {
                case Messages::Available:
                    $redis->srem($this->key('workers:working'), $payload['channel']);
                    $this->onAvailable();
                    break;
                case Messages::Working: 
                    $redis->sadd($this->key('workers:working'), $payload['channel']);
                    break;
            }
        });
    }

    public function close(): void
    {
        foreach ($this->workers as $worker) {
            // $worker->stop();
        }

        $this->unSubscribe($this->channel());
    }

    public function push(string $command, array $params = []): void
    {
        $job = json_encode(compact('command', 'params'));

        $this->redis->lpush($this->key('jobs'), $job);

        $this->notify();
    }

    private function key(string $keyname): string 
    {
        return "queue:{$this->id}:{$keyname}";
    }

    private function notify(): void
    {
        $worker = $this->available();

        if (! is_null($worker)) {
            $this->publish($worker, (string) Messages::HasNewJob);
        }
    }

    private function available(): string
    {
        $freeWorkers = $this->redis->sdiff(
            $this->key('workers'),
            $this->key('workers:working')
        );

        return array_pop($freeWorkers); 
    }

    private function hasJob(): bool
    { 
        $len = $this->redis->llen($this->key('jobs'));
        return $len > 0; 
    }

    public function nextJob(): array | null
    {
        $json = $this->redis->lpop($this->key('jobs'));
        if ($json) {
            $job = json_decode($json, true);
            return $job;
        }
    }

    private function onAvailable()
    {        
        if ($this->hasJob()) {
            $this->notify();
        }
    }
}
<?php

namespace App;

use App\Constants\Messages;
use App\Subscriber;
use Predis\Client;

abstract class QueueWorker implements Subscriber
{
    use SubscriberTrait;

    protected string $id;

    protected Client $redis;

    protected MessageQueue $queue;

    public function __construct(Client $redis)
    {
        $this->id = 'worker_' . time();
        $this->redis = $redis;
    }

    public abstract function handle(string $command, array $params = []): bool;

    public function channel(): string
    {
        return $this->id;
    }

    public function workFor(MessageQueue $queue)
    {
        $this->queue = $queue;
    }

    public function start()
    {
        $this->subscribe($this->channel(), function (string $message) {
            if ($message == Messages::HasNewJob) {
                if ($job = $this->queue->nextJob()) {
                    $this->working();
                    $this->handle($job['command'], $job['params']);
                    $this->available();
                }
            }
        });
    }

    public function stop()
    {
        $this->unSubscribe($this->channel());
    }

    private function working()
    {
        $this->publish($this->queue->channel(), json_encode([
            'message' => Messages::Working,
            'channel' => $this->channel(),
        ]));
    }

    private function available()
    {
        $this->publish($this->queue->channel(), json_encode([
            'message' => Messages::Available,
            'channel' => $this->channel(),
        ]));
    }
}

<?php
namespace App;

use Predis\Client;
use Exception;

class MessageQueue
{
    private string $id = "";

    private array $workers = [];

    private int $maxProcess = 3;

    private int $numProcess = 0;

    private bool $looping = false;

    private string $connection = "";

    public function __construct() 
    {
        $this->id = 'queue_' . time();
    }

    public function channel(): string 
    {
        return "queue:channel:{$this->id}";
    }

    public function addWorker(string $label, QueueWorker $worker): self
    {
        $this->workers[$label] = $worker;

        return $this;
    }

    public function maxProcess(int $max = 3): self
    {
        $this->maxProcess = $max;

        return $this;
    }

    public function redis(string $connection): self
    {
        $this->connection = $connection;
        
        return $this;
    }

    /**
     * Start listening the job queue
     */
    public function open(): void
    {
        go(function() {
            $redis = $this->createRedis();
            $redis->sadd('queues', $this->key());

            $this->looping = true;

            while ($this->looping) {
                $jobCount = $redis->llen($this->key('jobs'));
                if (($jobCount > 0) && ($this->numProcess < $this->maxProcess)) {
                    $job = $redis->lpop($this->key('jobs'));
                    $this->handle(Job::fromString($job));
                }
                else {
                    usleep(5);
                }
            }

            $redis->srem('queues', $this->id);
        });
    }

    /**
     * Stop listening for the job queue
     * 
     * @param bool $force should close the queue when it's not empty
     */
    public function close(bool $force = false): void
    {
        go(function() use ($force) {
            $redis = $this->createRedis();
    
            if ($force == false) {
                while ($redis->llen($this->key('jobs')) > 0) {
                    usleep(5);
                }
            }
    
            $this->looping = false;
        });
    }

    /**
     * Push new job to the queue
     */
    public function push(Job $job): void
    {
        static $redis;
        
        if (is_null($redis)) {
            $redis = $this->createRedis();
        }

        $redis->lpush($this->key('jobs'), $job->toString());
    }

    /**
     * Get Redis key for this queue
     */
    private function key(string $keyname = null): string 
    {
        $prefix = "queue:{$this->id}";
        if (! is_null($keyname)) {
            return "{$prefix}:{$keyname}";
        }
        return $prefix;
    }

    /**
     * Create a Redis client
     */
    private function createRedis(): Client
    {
        try {
            return new Client($this->connection);
        }
        catch(\Exception $e) {
            throw new Exception("Cannot connect to Redis with connection: $this->connection");
        }
    }

    /**
     * Create a new process and call a worker to handle the job
     */
    private function handle(Job $job): void
    {
        go(function() use ($job) {
            $this->numProcess++;

            $this->worker($job->label)?->handle($job->command);

            $this->numProcess--;
        });
    }

    /**
     * Get a worker matched the label
     */
    private function worker(string $label): QueueWorker | null
    {
        return $this->workers[$label] ?? null;
    }
}
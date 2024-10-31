<?php
namespace App;

use App\Constants\Messages;
use Closure;
use Predis\Client;

trait SubscriberTrait
{
    public function __construct()
    {
        if (! method_exists($this, 'channel')) {
        	throw new \Exception("channel() method is not declared.");
    	}

        if (! property_exists($this, 'redis') && !($this->redis instanceof Client)) {
        	throw new \Exception("redis is not declared as a property or is not an instance of the Predis\Client.");
    	}
    }

    /**
     * A helper function to help this trait retrieve the redis property with type hint
     */
    protected function getRedis(): Client
    {
        return $this->redis;
    }

    public function subscribe(string $channel, callable $handler) 
    {
        $redis = $this->getRedis();

        $pubsub = $redis->pubSubLoop();

        $pubsub->subscribe($channel);
        
        foreach ($pubsub as $message) {
            if ($message->kind == 'subscribe') {
                continue;
            }

            if ($message->payload == Messages::Stop) {
                $pubsub->unsubscribe();
                break;
            }

            $handler($message->payload);
        }
    }

    public function unSubscribe(string $channel)
    {
        $redis = $this->getRedis();
        $redis->publish($channel, Messages::Stop);
    }

    public function publish(string $channel, string $message) {
        $redis = $this->getRedis();
        $redis->publish($channel, $message);
    }
}
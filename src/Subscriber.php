<?php
namespace App;

interface Subscriber
{
    public function subscribe(string $channel, callable $handler);
    public function unSubscribe(string $channel);
    public function publish(string $channel, string $message);
    public function channel(): string;
}
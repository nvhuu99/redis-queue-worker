<?php
namespace App;

interface QueueWorker
{
    public function label(): string;
    public function handle(string $command): void;
}

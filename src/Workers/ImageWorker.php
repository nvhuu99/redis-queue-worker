<?php
namespace App\Workers;

use App\QueueWorker;

class ImageWorker implements QueueWorker
{
    public function label(): string
    {
        return 'image_processor';
    }

    public function handle(string $command): void 
    {
        $file = fopen('tmp/output', 'a');
        fwrite($file, "⚒️ #{$this->label()}:executing:{$command}" . PHP_EOL) ;
        // sleep(rand(2, 5));
        // sleep(10);
        fwrite($file, "✅ #{$this->label()}:done:{$command}" . PHP_EOL) ;
    }
}
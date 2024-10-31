<?php
namespace App;

use App\QueueWorker;

class ImageWorker extends QueueWorker
{
    public function handle(string $command, array $params = []): bool 
    {
        $json = json_encode($params, JSON_UNESCAPED_UNICODE);

        echo "#{$this->id}:{$command}:executing...";
        
        sleep(rand(2, 5));

        echo "#{$this->id}:{$command}:done✅:params:{$json}";

        return true;
    }
}
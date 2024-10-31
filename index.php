
<?php
require 'vendor/autoload.php';

use App\Job;
use App\MessageQueue;

$start = microtime(true);
echo "Running (10,000 times)..." . PHP_EOL;

Co\run(function () {
    $queue = (new MessageQueue())
                ->redis('tcp://redis:6379')
                ->maxProcess(3)
                ->addWorker('image', new \App\Workers\ImageWorker())
                ->addWorker('file', new \App\Workers\FileWorker())
    ;

    go(function () use ($queue) {
        $queue->open();
    });

    // Benchmark test with FileWorker
    // Test write long text 10.000 with 10 process
    go(function () use ($queue) {
        for ($i = 0; $i < 10000; ++$i) {
            $queue->push(Job::fromString('file:test'));
        }

        $queue->close();
    });
    
    // go(function () use ($queue) {
    //     echo "Enter commands:" . PHP_EOL;
    //     while(true) {
    //         try {
    //             echo '> ';
                
    //             $command = trim(fgets(STDIN));
    
    //             if ($command == 'exit') {
    //                 echo "Exiting: wait for last job to finish..." . PHP_EOL;
    //                 break;
    //             }
    
    //             $queue->push(Job::fromString($command));
    //         }
    //         catch (\Exception $e) {
    //             echo "Wrong command format. Please try again: " . PHP_EOL;
    //         }
    //     }

    //     $queue->close(true);
    // });
});

echo "Finished after: " . (microtime(true) - $start) . PHP_EOL;



<?php
require 'vendor/autoload.php';

use App\Job;
use App\MessageQueue;

$start = microtime(true);

Co\run(function () {
    // Setup the queue
    $queue = (new MessageQueue())
                ->redis('tcp://redis:6379')
                ->maxProcess(3) // set to your desire number (more than 0)
                ->addWorker('image', new \App\Workers\ImageWorker())
                ->addWorker('file', new \App\Workers\FileWorker())
                // ... Add more workers
    ;

    // Start listening
    go(function () use ($queue) {
        $queue->open();
    });

    // Usecase 1:
    // Benchmark test: write long text 10.000 times (please create /tmp before)
    // go(function () use ($queue) {
    //     for ($i = 0; $i < 10000; ++$i) {
    //         $queue->push(Job::fromString('file:test'));
    //     }

    //     $queue->close();
    // });
    
    // Usecase 2:
    // Command enter manually
    go(function () use ($queue) {
        echo "Enter commands (use 'exit' to close):" . PHP_EOL;
        while(true) {
            try {
                echo '> ';
                
                $command = trim(fgets(STDIN));
    
                if ($command == 'exit') {
                    echo "Exiting: wait for last job to finish..." . PHP_EOL;
                    break;
                }
    
                $queue->push(Job::fromString($command));
            }
            catch (\Exception $e) {
                echo "Wrong command format. Please try again with the \"worker_label:worker_command\" format" . PHP_EOL;
            }
        }

        $queue->close(true);
    });
});

echo "Finished after: " . (microtime(true) - $start) . PHP_EOL;


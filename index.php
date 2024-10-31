
<?php
require 'vendor/autoload.php';

use Predis\Client;
use App\ImageWorker;
use App\MessageQueue;

Co\run(function() {

    $worker = new ImageWorker(new Client('tcp://redis:6379'));
    $queue = new MessageQueue(new Client('tcp://redis:6379'));

    go(function () use ($worker) {
        $worker->start();
        $worker->stop();
    });

    go(function () use ($queue, $worker) {
        $queue->open($worker);
        $queue->close();
    });

    go(function () use ($queue) {
        $command = "";
        while($command != 'exit') {
            echo "Enter command: ";
            $command = fgets(STDIN);

            $queue->push($command);
        }
    });
});

// use Predis\Client;
// use Swoole\Coroutine;

// Co\run(function () {
//     // Create a Redis client
//     $redis = new Client('tcp://redis:6379');
//     $redis2 = new Client('tcp://redis:6379');

//     // Start the subscriber in a separate coroutine
//     go(function () use ($redis) {
//         echo '1'. PHP_EOL;

//         $pubsub = $redis->pubSubLoop();

//         $pubsub->subscribe('my_channel');
        
//         foreach ($pubsub as $message) {
//             if ($message->kind == 'subscribe') {
//                 continue;
//             }

//             if ($message->payload == 'exit') {
//                 $pubsub->unsubscribe();
//                 echo 'Unsubcribed';
//                 break;
//             }

//             echo 'Receive: '. $message->payload . PHP_EOL;
//         }
//         echo '1-end' . PHP_EOL;
//     });

//     // Start listening for user input to publish messages
//     go(function () use ($redis2) {
//         echo '2'. PHP_EOL;

//         while (true) {
//             echo "Enter message to publish (type 'exit' to quit): ". PHP_EOL;
//             $input = trim(fgets(STDIN));
            
//             $redis2->publish('my_channel', $input);

//             if ($input === 'exit') {
//                 break;
//             }

//             // Publish the message to Redis
//             echo "Published message: $input\n";
//         }
//     });
// });

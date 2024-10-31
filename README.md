# Redis Queue Worker

A simple message queue implemented with Redis and PHP Swoole extensions.

## Overview

This project enables efficient, asynchronous message processing by combining the power of Redis with the PHP Swoole coroutine capabilities. You can define multiple worker types and assign specific jobs to them, making this solution highly adaptable to various task processing needs.

## Sample Code

```php
<?php

Co\run(function () {
    // Setup the queue
    $queue = (new MessageQueue())
                ->redis('tcp://redis:6379')
                ->maxProcess(3) // Set to the desired number (minimum 1)
                ->addWorker('image', new \App\Workers\ImageWorker())
                ->addWorker('file', new \App\Workers\FileWorker());
                // ... Add more workers as needed

    // Start listening for jobs
    go(function () use ($queue) {
        $queue->open();
    });

    // Adding jobs to the queue
    go(function () use ($queue) {
        $queue->push(Job::fromString('image:rotate'));
        $queue->push(Job::fromString('file:clean'));
        // ... Add more jobs as needed

        $queue->close(true);
    });
});
```

## Getting Started

### Running the Queue Worker

Build and run the container:

```bash
docker compose up -d --build
```

### Accessing the Container

To access the running container’s shell:

```bash
docker exec -it queue_worker bash
```

### Running Tests

Inside the container, navigate to the project directory and run the test:

```bash
cd /var/redis-queue-worker
composer install
php -f index.php
```

## License

This project is licensed under the MIT License.

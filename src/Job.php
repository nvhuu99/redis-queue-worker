<?php
namespace App;

class Job
{
    /**
     * Label of the worker
     */
    public string $label;

    /**
     * Worker command
     */
    public string $command;

    public function __construct(string $label, string $command)
    {
        $this->label = $label;
        $this->command = $command;
    }

    public function toString(): string
    {
        return "{$this->label}:{$this->command}";
    }

    public static function fromString(string $command): Job
    {
        $pos = strpos($command, ':');
        if ($pos === false) {
            throw new \Exception("Wrong command format <label:command (params...)>");
        }

        $label = substr($command, 0, $pos);
        $command = substr($command, $pos + 1);
        
        return new Job($label, $command);
    }
}
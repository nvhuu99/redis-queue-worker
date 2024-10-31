<?php
namespace App\Constants;

enum Messages: string
{
    case Stop = 'stop_worker';
    case Available = 'worker_available';
    case Working = 'worker_working';
    case HasNewJob = 'has_new_job';
}
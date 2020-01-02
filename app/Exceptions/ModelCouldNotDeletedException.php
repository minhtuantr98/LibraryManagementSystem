<?php

namespace App\Exceptions;

use Log;
use Exception;

class ModelCouldNotDeletedException extends Exception
{
    public function report()
    {
        Log::info('U cant delete it');
    }
}

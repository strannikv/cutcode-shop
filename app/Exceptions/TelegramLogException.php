<?php

namespace App\Exceptions;

use Exception;

class TelegramLogException extends Exception
{
    public function __construct()
    {
        parent::__construct();
    }

}

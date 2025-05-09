<?php

namespace App\Exception;

class SystemHttpException extends AbstractSystemHttpException
{
    public function __construct(string $message)
    {
        // один из вероятных кодов, другие имплементации могут возвращать свои коды
        parent::__construct($message, 500);
    }
}
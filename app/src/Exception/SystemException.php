<?php

declare(strict_types=1);

namespace App\Exception;

class SystemException extends AbstractSystemException
{
    public function __construct(string $message)
    {
        // один из вероятных кодов, другие имплементации могут возвращать свои коды
        parent::__construct($message, 400);
    }
}
<?php

declare(strict_types=1);

namespace App\Service\System\Request;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface RequestServiceInterface
{
    public function send(
        string $method,
        string $url,
        string $body = null,
        array $headers = [],
        array $queryParams = []
    ): ResponseInterface;
}
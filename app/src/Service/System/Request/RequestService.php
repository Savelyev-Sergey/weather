<?php

declare(strict_types=1);

namespace App\Service\System\Request;

use App\Exception\SystemHttpException;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TimeoutExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

readonly class RequestService implements RequestServiceInterface
{
    protected const OPTION_HEADERS = 'headers';
    protected const OPTION_QUERY_PARAMS = 'query';
    protected const OPTION_QUERY_BODY = 'body';
    protected const OPTION_QUERY_TIMEOUT = 'timeout';

    protected const REQUEST_TIMEOUT = 1;

    public function __construct(
        protected HttpClientInterface $httpClient,
    ) {
    }

    public function send(
        string $method,
        string $url,
        string $body = null,
        array $headers = [],
        array $queryParams = []
    ): ResponseInterface {
        $options = [
            self::OPTION_QUERY_TIMEOUT => self::REQUEST_TIMEOUT,
            self::OPTION_QUERY_BODY => $body ?? '{}',
        ];

        if ($headers) {
            $options[self::OPTION_HEADERS] = $headers;
        }

        if ($queryParams) {
            $options[self::OPTION_QUERY_PARAMS] = $queryParams;
        }

        try {
            return $this->httpClient->request($method, $url, $options);
        } catch (TimeoutExceptionInterface $exception) {
            throw new SystemHttpException('Timeout > ' . self::REQUEST_TIMEOUT);
        } catch (ServerExceptionInterface|TransportExceptionInterface $exception) {
            throw new SystemHttpException($exception->getMessage());
        } finally {
            // здесь при необходимости может быть логирование всех запросов и ответов
        }
    }
}
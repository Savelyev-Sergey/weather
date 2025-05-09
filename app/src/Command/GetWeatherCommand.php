<?php

declare(strict_types=1);

namespace App\Command;

use App\DTO\Weather\CreateWeatherRequestDTO;
use App\Entity\City;
use App\Exception\AbstractSystemHttpException;
use App\Service\City\CityServiceInterface;
use App\Service\System\Request\RequestServiceInterface;
use App\Service\Weather\WeatherServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

#[AsCommand(
    name: 'GetWeather',
    description: 'Add weather information',
    aliases: ['app:get-weather'],
)]
class GetWeatherCommand extends Command
{
    protected const WEATHER_SERVICE_URL = 'https://api.weatherapi.com/v1/current.json';

    public function __construct(
        protected readonly string $weatherApiKey,
        protected readonly RequestServiceInterface $requestService,
        protected readonly CityServiceInterface $cityService,
        protected readonly WeatherServiceInterface $weatherService,
        protected readonly LoggerInterface $logger,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var City $city */
        foreach ($this->cityService->getAllCities() as $city) {
            try {
                $response = $this->requestService
                    ->send(
                        method: Request::METHOD_GET,
                        url: self::WEATHER_SERVICE_URL,
                        queryParams: [
                            'key' => $this->weatherApiKey,
                            'q' => $city->getName(),
                        ]
                    );

                if ($response->getStatusCode() !== Response::HTTP_OK) {
                    $this->logger->error(
                        'Get weather command STATUS error',
                        [
                            'code' => $response->getStatusCode(),
                            'message' => $response->getContent(false),
                        ]
                    );

                    continue;
                }

                $responseData = json_decode($response->getContent(), true);

                $this->weatherService->create(
                    new CreateWeatherRequestDTO(
                        city: $city,
                        temperature: $responseData['current']['temp_c'],
                        conditions: $responseData['current']['condition']['text'],
                        humidity: $responseData['current']['humidity'],
                        windSpeed: $responseData['current']['wind_kph'],
                        lastUpdated: new \DateTimeImmutable($responseData['current']['last_updated']),
                    )
                );
            } catch (AbstractSystemHttpException $exception) {
                $this->logger->error(
                    'Get weather command HttpException error',
                    [
                        'code' => $exception->getCode(),
                        'message' => $exception->getMessage()
                    ]
                );
            } catch (Throwable $exception) {
                $this->logger->error(
                    'Get weather command Throwable error',
                    [
                        'code' => $exception->getCode(),
                        'message' => $exception->getMessage()
                    ]
                );
            }
        }

        $io->success('Add weather information command is Ok.');

        return Command::SUCCESS;
    }
}

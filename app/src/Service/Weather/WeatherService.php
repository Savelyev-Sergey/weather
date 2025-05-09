<?php

declare(strict_types=1);

namespace App\Service\Weather;

use App\DTO\Weather\CreateWeatherRequestDTO;
use App\DTO\Weather\WeatherResponseDTO;
use App\Entity\Weather;
use App\Repository\WeatherRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class WeatherService implements WeatherServiceInterface
{
    public function __construct(
        protected WeatherRepository $weatherRepository,
        protected EntityManagerInterface $entityManager
    )
    {
    }

    public function view(?string $city): ?WeatherResponseDTO
    {
        $data  = null;
        if (
            $city
            /* @var Weather $result */
            && $result  = $this->weatherRepository->getWeatherByCityName($city)
        ) {

            $data = new WeatherResponseDTO(
                city: $result[0]->getCity()->getName(),
                temperature: $result[0]->getTemperature(),
                conditions: $result[0]->getConditions(),
                humidity: $result[0]->getHumidity(),
                windSpeed: $result[0]->getWindSpeed(),
                lastUpdated: $result[0]->getLastUpdated(),
            );
        }

        return $data;
    }

    public function create(CreateWeatherRequestDTO $createWeatherRequestDTO): WeatherResponseDTO
    {
        $weather = new Weather();
        $weather
            ->setCity($createWeatherRequestDTO->city)
            ->setTemperature($createWeatherRequestDTO->temperature)
            ->setConditions($createWeatherRequestDTO->conditions)
            ->setHumidity($createWeatherRequestDTO->humidity)
            ->setWindSpeed($createWeatherRequestDTO->windSpeed)
            ->setLastUpdated($createWeatherRequestDTO->lastUpdated);

        $this->entityManager->persist($weather);
        $this->entityManager->flush();

        return new WeatherResponseDTO(
            city: $weather->getCity()->getName(),
            temperature: $weather->getTemperature(),
            conditions: $weather->getConditions(),
            humidity: $weather->getHumidity(),
            windSpeed: $weather->getWindSpeed(),
            lastUpdated: $weather->getLastUpdated(),
        );
    }
}
<?php

declare(strict_types=1);

namespace App\Service\Weather;

use App\DTO\Weather\CreateWeatherRequestDTO;
use App\DTO\Weather\WeatherResponseDTO;

interface WeatherServiceInterface
{
    public function view(?string $city): ?WeatherResponseDTO;

    public function create(CreateWeatherRequestDTO $createWeatherRequestDTO): WeatherResponseDTO;
}
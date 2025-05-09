<?php

declare(strict_types=1);

namespace App\DTO\Weather;

use Spatie\DataTransferObject\DataTransferObject;

class WeatherResponseDTO extends DataTransferObject
{
    public readonly string $city;

    public readonly string $temperature;

    public readonly string $conditions;

    public readonly int $humidity;

    public readonly string $windSpeed;

    public  readonly \DateTimeImmutable $lastUpdated;
}
<?php

declare(strict_types=1);

namespace App\DTO\Weather;

use App\Entity\City;
use Spatie\DataTransferObject\DataTransferObject;

class CreateWeatherRequestDTO extends DataTransferObject
{
    public readonly City $city;

    public readonly string $temperature;

    public readonly string $conditions;

    public readonly int $humidity;

    public readonly string $windSpeed;

    public  readonly \DateTimeImmutable $lastUpdated;
}
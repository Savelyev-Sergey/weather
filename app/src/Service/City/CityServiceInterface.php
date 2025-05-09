<?php

declare(strict_types=1);

namespace App\Service\City;

interface CityServiceInterface
{
    public function getAllCities(): array;
}
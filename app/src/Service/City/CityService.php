<?php

declare(strict_types=1);

namespace App\Service\City;

use App\Repository\CityRepository;

readonly class CityService implements CityServiceInterface
{
    public function __construct(
        protected CityRepository $cityRepository,
    ) {
    }

    public function getAllCities(): array
    {
        return $this->cityRepository->findAll();
    }
}
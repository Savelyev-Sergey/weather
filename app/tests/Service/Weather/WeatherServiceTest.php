<?php

declare(strict_types=1);

namespace App\Tests\Service\Weather;

use App\DTO\Weather\CreateWeatherRequestDTO;
use App\DTO\Weather\WeatherResponseDTO;
use App\Repository\CityRepository;
use App\Repository\WeatherRepository;
use App\Service\Weather\WeatherService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WeatherServiceTest extends KernelTestCase
{
    protected EntityManagerInterface $entityManager;
    protected CityRepository $cityRepository;
    protected WeatherRepository $weatherRepository;
    protected WeatherService $service;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $this->entityManager = $container->get(EntityManagerInterface::class);
        $this->cityRepository = $container->get(CityRepository::class);
        $this->weatherRepository = $container->get(WeatherRepository::class);
        $this->service = $container->get(WeatherService::class);

        $this->assertNotNull($this->entityManager);
        $this->assertNotNull($this->cityRepository);
        $this->assertNotNull($this->service);
    }

    public function testCreate(): void
    {
        $expectedCount = count($this->weatherRepository->findAll()) + 1;

        $result = $this->service->create(
            new CreateWeatherRequestDTO(
                city: $this->cityRepository->findOneByName('London'),
                temperature: '12',
                conditions: 'Cond',
                humidity: 12,
                windSpeed: '14.2',
                lastUpdated: new \DateTimeImmutable(),
            )
        );

        $this->assertInstanceOf(WeatherResponseDTO::class, $result);
        $this->assertSame($expectedCount, count($this->weatherRepository->findAll()));
    }

    public function testViewWithCityName(): void
    {
        $this->assertInstanceOf(WeatherResponseDTO::class, $this->service->view('London'));
    }

    public function testViewWithoutCityName(): void
    {
        $this->assertSame(null, $this->service->view(null));
    }

    public function testViewWithCityNoData(): void
    {
        $this->assertSame(null, $this->service->view('Lon'));
    }
}

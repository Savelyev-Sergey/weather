<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\WeatherRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeatherRepository::class)]
#[ORM\Table(name: 'weather')]
#[ORM\Index(name: 'IDX__city', columns: ['city_id'])]
class Weather
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(name: 'id', type: 'bigint', options: ['unsigned' => true])]
    private int $id;

    #[ORM\ManyToOne(targetEntity: City::class)]
    #[ORM\JoinColumn(name: 'city_id',referencedColumnName: 'id')]
    private City $city;

    #[ORM\Column(name: 'temperature', type: 'decimal', precision: 5, scale: 1)]
    private string $temperature;

    #[ORM\Column(name: 'conditions', type: 'string', length: 255)]
    private string $conditions;

    #[ORM\Column(name: 'humidity', type: 'smallint')]
    private int $humidity;

    #[ORM\Column(name: 'wind_speed', type: 'decimal', precision: 5, scale: 1)]
    private string $windSpeed;

    #[ORM\Column(name: 'last_updated', type: 'datetime_immutable')]
    private \DateTimeImmutable $lastUpdated;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCity(): City
    {
        return $this->city;
    }

    public function setCity(City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getTemperature(): string
    {
        return $this->temperature;
    }

    public function setTemperature(string $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getConditions(): string
    {
        return $this->conditions;
    }

    public function setConditions(string $conditions): self
    {
        $this->conditions = $conditions;

        return $this;
    }

    public function getHumidity(): int
    {
        return $this->humidity;
    }

    public function setHumidity(int $humidity): self
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getWindSpeed(): string
    {
        return $this->windSpeed;
    }

    public function setWindSpeed(string $windSpeed): self
    {
        $this->windSpeed = $windSpeed;

        return $this;
    }

    public function getLastUpdated(): \DateTimeImmutable
    {
        return $this->lastUpdated;
    }

    public function setLastUpdated(\DateTimeImmutable $lastUpdated): self
    {
        $this->lastUpdated = $lastUpdated;

        return $this;
    }
}

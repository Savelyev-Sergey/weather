<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\City;
use App\Entity\Weather;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Weather>
 */
class WeatherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Weather::class);
    }

    public function getWeatherByCityName(string $cityName): array
    {
        return $this->createQueryBuilder('weather')
            ->leftJoin(
                City::class,
                'city',
                Join::WITH,
                'weather.city = city.id'
            )
            ->where('city.name = :cityName')
            ->setParameter('cityName', $cityName)
            ->orderBy('weather.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }
}

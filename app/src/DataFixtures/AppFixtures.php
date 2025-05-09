<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Country;
use App\Entity\Weather;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $country = new Country();
        $country->setName('United Kingdom');
        $manager->persist($country);

        $city = new City();
        $city
            ->setName('London')
            ->setCountry($country);
        $manager->persist($city);

        for ($i = 30; $i >= 1; $i--) {
            $weather = new Weather();
            $weather
                ->setCity($city)
                ->setTemperature('24.1')
                ->setConditions('Partly cloudy')
                ->setHumidity(51)
                ->setWindSpeed('12.6')
                ->setLastUpdated((new \DateTimeImmutable())->sub(new \DateInterval("P{$i}D")));
            $manager->persist($weather);
        }

        $manager->flush();
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherControllerTest extends WebTestCase
{
    public function testWithoutCity(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/weather');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h4', 'Нет данных');
    }

    public function testWithCity(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/weather/London');

        $this->assertResponseIsSuccessful();
        $this->assertCount(1, $crawler->filter('.wlv__currentTemp'));
    }

    public function testWithCityNotData(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/weather/Lon');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h4', 'Нет данных');
    }
}

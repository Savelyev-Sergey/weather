<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\Weather\WeatherServiceInterface;

final class WeatherController extends AbstractController
{
    public function __construct(
        protected WeatherServiceInterface $weatherService,
    )
    {
    }

    #[Route('/weather/{city?}', name: 'app_weather', methods: ['GET'])]
    public function index(?string $city): Response
    {
        return $this->render('weather/index.html.twig', [
            'controller_name' => 'WeatherController',
            'weather' => $this->weatherService->view($city)
        ]);
    }
}

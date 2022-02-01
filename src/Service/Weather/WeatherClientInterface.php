<?php

declare(strict_types=1);

namespace App\Service\Weather;

interface WeatherClientInterface
{
    public const API_URL = 'http://api.openweathermap.org/data/2.5/weather';

    public function getWeatherByCity(string $city): string;
}
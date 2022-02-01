<?php

declare(strict_types=1);

namespace App\Service\Weather;

use App\Service\Exception\WeatherClientException;

final class WeatherClient implements WeatherClientInterface
{
    public function __construct(
        private string $appid
    )
    {

    }

    public function getWeatherByCity(string $city): string
    {
        $url = self::API_URL . '?q=' . urldecode($city) . '&appid=' . $this->appid . '&units=metric';

        try {
            $weatherResponse = file_get_contents($url);
            if (!$weatherResponse){
                throw new WeatherClientException('Failed to fetch weather for: ' . $city);
            }
            $weather = json_decode($weatherResponse);

            $output = sprintf(
                "%s , %d degrees celcius",
                $weather?->weather[0]?->description,
                (int)$weather?->main?->feels_like
            );

        } catch (\Throwable $exception) {
            throw new WeatherClientException('Failed to fetch weather for: ' . $city);
        }
        return $output;
    }
}
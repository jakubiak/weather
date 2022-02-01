<?php

declare(strict_types=1);

namespace App\Service\Exception;

final class WeatherClientException extends \RuntimeException
{
    /** @var string  */
    protected $message = 'Failed to fetch weather';
}
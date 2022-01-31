<?php

declare(strict_types=1);

namespace App\ConsoleCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WeatherCommand extends Command
{
    protected static $defaultName = 'app:weather';

    public function __construct(
        private string $appid
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Show weather for given city');
        $this->setHelp('This command allows you to fetch weather from openweathermap.org');
        $this->addArgument('city', InputArgument::REQUIRED, 'Provide city name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $city = urldecode($input->getArgument('city'));
        $url = 'http://api.openweathermap.org/data/2.5/weather?q='.$city.'&appid='.$this->appid.'&units=metric';

        try {
            $weatherResponse = file_get_contents($url);
            $weather = json_decode($weatherResponse);

            $output->writeln(
                sprintf(
                    "weather: %s , %d degrees celcius",
                    $weather?->weather[0]?->description,
                    (int)$weather?->main?->feels_like
                )
            );

        } catch (\Throwable $exception) {
            $output->writeln('Failed to fetch weather for: ' . $city);
        }

        return Command::SUCCESS;
    }
}
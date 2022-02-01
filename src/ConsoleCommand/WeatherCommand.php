<?php

declare(strict_types=1);

namespace App\ConsoleCommand;

use App\Service\Exception\WeatherClientException;
use App\Service\Weather\WeatherClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class WeatherCommand extends Command
{
    protected static $defaultName = 'app:weather';

    public function __construct(
        private WeatherClientInterface $weatherClient
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
        try {

            $weather = $this->weatherClient
                ->getWeatherByCity(
                    $input->getArgument('city')
                );

            $output->writeln($weather);

        } catch (WeatherClientException $exception) {
            $output->writeln($exception->getMessage());
        } catch (\Throwable $exception) {
            $output->writeln("Unexpected error occurred: " . $exception->getMessage());
        }

        return Command::SUCCESS;
    }
}
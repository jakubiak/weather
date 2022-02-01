<?php

declare(strict_types=1);

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class WeatherCommandTest extends KernelTestCase
{

    public function testExecuteWithoutCityName()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:weather');

        $this->expectException(\RuntimeException::class);

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);


    }

    public function testExecuteWithCorrectCityName()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:weather');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'city' => 'Berlin',
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString(' degrees celcius', $output);
    }

    public function testExecuteWithWrongCity()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $command = $application->find('app:weather');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'city' => 'CityNotExists',
        ]);

        $commandTester->assertCommandIsSuccessful();

        $output = $commandTester->getDisplay();
        $this->assertStringStartsWith('Failed to fetch weather for: CityNotExists', $output);
    }
}
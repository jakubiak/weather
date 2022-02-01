WEATHER checker
===============================

Requirements
----------------------------
```text
PHP version at least 8.0 
```

Setting up
----------------------------

```text
composer install

edit variable OPENWEATHERMAP_APPID in .env file 
```

How to run
----------------------------------

Enter command `bin/console app:weather {city}` in your terminal

Example: `bin console app:weather Berlin`

Main project classes:
----------------------------
- App\ConsoleCommand\WeatherCommand
- App\Service\Weather\WeatherClient

For developers
----------------------------------

Run `php bin/phpunit` for tests execution

Run `composer phpstan` for analyze code
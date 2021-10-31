<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';
define("MODELS", [
    "vehicle" => [
        "endpoint" => "vehicles",
        "insertStatement" => "INSERT INTO vehicle
        (name, model, manufacturer, cost_in_credits, `length`, max_atmosphering_speed, crew, passengers, cargo_capacity, consumables, vehicle_class, pilots, films, created, edited, url, count)
        VALUES "
    ],
    "starship" => [
        "endpoint" => "starships",
        "insertStatement" => "INSERT INTO starship
        (name, model, manufacturer, cost_in_credits, `length`, max_atmosphering_speed, crew, passengers, cargo_capacity, consumables, hyperdrive_rating, mglt, starship_class, pilots, films, created, edited, url, count)
        VALUES "
    ]
]);

define("SWAPI_BASE_URL", 'https://swapi.dev/api/');

$baseDir = __DIR__ . '/../../';
$dotenv = Dotenv\Dotenv::createImmutable($baseDir);
$envFile = $baseDir . '.env';
if (file_exists($envFile)) {
    $dotenv->load();
}
$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'DB_PORT']);
$settings = require __DIR__ . '/settings.php';

$app = new \Slim\App($settings);
$app->add(new \CorsSlim\CorsSlim());
$container = $app->getContainer();

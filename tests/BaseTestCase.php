<?php

declare(strict_types=1);

namespace Tests;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use Psr\Http\Message\ResponseInterface;

class BaseTestCase extends \PHPUnit\Framework\TestCase
{

    public function runApp(
        string $requestMethod,
        string $requestUri,
        array $requestData = null
    ): ResponseInterface {
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );

        $request = Request::createFromEnvironment($environment);

        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        $baseDir = __DIR__ . '//../';
        $dotenv = \Dotenv\Dotenv::createUnsafeImmutable($baseDir);
        $envFile = $baseDir . '.env';
        
        if (file_exists($envFile)) {
            $dotenv->load();
        }

        $settings = require __DIR__ . '/../src/app/settings.php';
        $app = new App($settings);
        $container = $app->getContainer();
        require_once __DIR__ . '/../src/routes/teachaway.php';

        return $app->process($request, new Response());
    }
}
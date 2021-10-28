<?php
// # use Namespaces for HTTP request
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// # include the Slim framework
require '../vendor/autoload.php';

// # include DB connection file
require '../src/config/db.php';

// # create new Slim instance
$app = new \Slim\App;

// # create your First Route
$app->get('/test', function  (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
   
    echo "Hello, testing";
});
// # let Slim starts to run
// without run(), the api routes won't work
$app->run();
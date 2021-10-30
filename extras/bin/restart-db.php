<?php

declare(strict_types=1);

require __DIR__ . '/../../src/app/app.php';
use GuzzleHttp\Client;

try {
    $db = $container->get('settings')['db'];
    $host = $db['host'];
    $name = $db['name'];
    $user = $db['user'];
    $pass = $db['pass'];
    $port = $db['port'];

    $pdo = new PDO("mysql:host=${host};port=$port;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("DROP DATABASE IF EXISTS ${name}");
    echo '[OK] Database droped successfully' . PHP_EOL;

    $pdo->exec("CREATE DATABASE ${name}");
    echo '[OK] Database created successfully' . PHP_EOL;

    $pdo->exec("USE ${name}");
    echo '[OK] Database selected successfully' . PHP_EOL;

    $sql = file_get_contents(__DIR__ . '/../../database/db.sql');
    $pdo->exec($sql);
    echo '[OK] tables inserted successfully' . PHP_EOL;


////////////IMporting swapi data

$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'http://httpbin.org',
    // You can set any number of default request options.
    'timeout'  => 2.0,
]);

// Create a client with a base URI
$client = new GuzzleHttp\Client(['base_uri' => 'https://swapi.dev/api/']);



// Send a request to https://foo.com/api/test
$response = $client->request('GET', 'vehicles');

if ($response->getStatusCode() == 200){
    $body = $response->getBody();
    $body = (string)$body;
    $bodyArr = json_decode($body, true);
    $ended = false;

    $insertStment = "INSERT INTO teachaway2.vehicle
    (name, model, manufacturer, cost_in_credits, `length`, max_atmosphering_speed, crew, passengers, cargo_capacity, consumables, vehicle_class, pilots, films, created, edited, url, count)
    VALUES ";

    $aux = [];
    $page = 1;
    while (!$ended){

        $next = $bodyArr["next"];
        if (is_null($next)){
            $ended = true;
            continue;
        }

        foreach($bodyArr["results"] as $vehicle){

            // getting the last registered user
            $stmt = $pdo->query("select CONVERT_TZ('".$vehicle["created"]."', '+00:00','+00:00') as created;");
            $created = $stmt->fetch()["created"];

            $stmt = $pdo->query("select CONVERT_TZ('".$vehicle["edited"]."', '+00:00','+00:00') as edited;");
            $edited = $stmt->fetch()["edited"];

            array_push($aux, "('".
            implode("', '", 
                [
                    $vehicle["name"],
                    $vehicle["model"],
                    $vehicle["manufacturer"],
                    $vehicle["cost_in_credits"],
                    $vehicle["length"],
                    $vehicle["max_atmosphering_speed"],
                    $vehicle["crew"],
                    $vehicle["passengers"],
                    $vehicle["cargo_capacity"],
                    $vehicle["consumables"],
                    $vehicle["vehicle_class"],
                    implode(",", $vehicle["pilots"]),
                    implode(",", $vehicle["films"]),
                    $created,
                    $edited,
                    $vehicle["url"],
                    0
                ]
            )."')");

        }

        //you must replace endpoint with next value with query string
        $response = $client->request('GET', 'vehicles?'.parse_url($next, PHP_URL_QUERY));
        
        if ($response->getStatusCode() == 200){
            $body = $response->getBody();
            $body = (string)$body;
        
            $bodyArr = json_decode($body, true);
        }

        echo "[OK] Page $page for vehicles inserted" . PHP_EOL;
        $page++;
       
    }

    $insertStment = $insertStment.implode(",",$aux);
    $pdo->exec($insertStment);


    //////////////////////////////////////////////////////////////////



    echo '[OK] SWAPI data imported successfully' . PHP_EOL;

}


} catch (PDOException $exception) {
    echo '[ERROR] ' . $exception->getMessage() . PHP_EOL;
}
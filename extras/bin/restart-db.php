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

    $pdo->exec(importData('vehicle', $pdo));
    $pdo->exec(importData('starship', $pdo));

    echo '[OK] SWAPI data imported successfully' . PHP_EOL;

} catch (PDOException $exception) {
    echo '[ERROR] ' . $exception->getMessage() . PHP_EOL;
}


function importData($model, $pdo){

    // Create a client with a base URI
    $client = new GuzzleHttp\Client(['base_uri' => SWAPI_BASE_URL]);
    $modelArr = MODELS[$model];
    $response = $client->request('GET', $modelArr['endpoint']);

    if ($response->getStatusCode() == 200){
        $body = $response->getBody();
        $body = (string)$body;
        $bodyArr = json_decode($body, true);
        $ended = false;

        $insertStment = $modelArr['insertStatement'];

        $aux = [];
        $page = 1;
        while (!$ended){

            foreach($bodyArr["results"] as $vehicle){

                $stmt = $pdo->query("select CONVERT_TZ('".$vehicle["created"]."', '+00:00','+00:00') as created;");
                $created = $stmt->fetch()["created"];

                $stmt = $pdo->query("select CONVERT_TZ('".$vehicle["edited"]."', '+00:00','+00:00') as edited;");
                $edited = $stmt->fetch()["edited"];

                switch($model){

                    case "vehicle":

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

                    break;

                    case "starship":

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
                                $vehicle["hyperdrive_rating"],
                                $vehicle["MGLT"],
                                $vehicle["starship_class"],
                                implode(",", $vehicle["pilots"]),
                                implode(",", $vehicle["films"]),
                                $created,
                                $edited,
                                $vehicle["url"],
                                0
                            ]
                        )."')");

                    break;

                }

            }

            echo "[OK] Page $page for $model inserted" . PHP_EOL;
            $page++;

            $next = $bodyArr["next"];
            if (is_null($next)){
                $ended = true;
                continue;
            }

            $response = $client->request('GET', $modelArr["endpoint"]."?".parse_url($next, PHP_URL_QUERY));
            
            if ($response->getStatusCode() == 200){
                $body = $response->getBody();
                $body = (string)$body;
            
                $bodyArr = json_decode($body, true);
            }    
        
        }

        $insertStment = $insertStment.implode(",",$aux);
        return $insertStment;
    }
}
<?php
require __DIR__ .'/../middleware/ValidationGetInfoMiddleware.php';
require __DIR__ .'/../middleware/ValidationPutQuantityMiddleware.php';
require __DIR__ .'/../middleware/ValidationPutIncDecMiddleware.php';

// # endpoint list
$app->get('/', function  (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {

  $appData = $this->get('settings')['app'];
  $url = $appData['domain'];
  $endpoints = [
      'Vehicles' => [
        "GET Search by criteria" => $url . '/teachaway/vehicle/<name>',
        "PUT Setting initial quantity to vehicles" => $url . '/teachaway/vehicle/<id>',
        "PUT Increase vehicles quantity" => $url . '/teachaway/vehicle/increase/<id>',
        "PUT Decrease vehicles quantity" => $url . '/teachaway/vehicle/decrease/<id>',
      ],
      'Starships' => [
        "GET Search by criteria" => $url . '/teachaway/starship/<name>',
        "PUT Setting initial quantity to starships" => $url . '/teachaway/starship/<id>',
        "PUT Increase starships quantity" => $url . '/teachaway/starship/increase/<id>',
        "PUT Decrease starships quantity" => $url . '/teachaway/starship/decrease/<id>',
      ],
      
      'this help' => $url . '',
  ];
  $message = [
      'endpoints' => $endpoints,
      'version' => "1.0",
      'timestamp' => time(),
  ];

  return $response->withJson($message, 200);
  

});

// # allow to get the total number of units for a specific vehicle or starship
$app->get('/teachaway/{type}/{name}', function  (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {

    $sql = "SELECT id, name, count
    FROM ".$args["type"]."
    WHERE UPPER(name) like CONCAT('%', '".$args["name"]."', '%');";

    try {
      $db = new db();
      $db = $db->connect($this->get('settings')["db"]);
  
      $stmt = $db->query( $sql );
      $result = $stmt->fetchAll( PDO::FETCH_OBJ );
      $db = null; // clear db object

      if (!$result){
          return $response->withStatus(404);
      }
      
      return $response->withJson($result, 200);
        
    }
    catch( PDOException $e ) {
      // show error message as Json format
      return $response->withJson([
        "error" => [
            "msg" => $e->getMessage(),
        ]], 400);
    }
    

})->add( new ValidationGetInfoMiddleware());

// # allow to set the total number of units for a specific vehicle or starship
$app->put('/teachaway/{type}/{id}', function  (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {

    try {
      $db = new db();
      $db = $db->connect($this->get('settings')["db"]);

      $stmt = $db->query( "select id from ".$args["type"]." where id = ".$args["id"].";");
      $result = $stmt->fetch( PDO::FETCH_OBJ );
      
      if (!$result){
          return $response->withStatus(404);
      }

      $sql = "UPDATE ".$args["type"]."
      SET count=".$request->getParam('quantity')."
      WHERE id=".$args["id"].";";

      $stmt = $db->exec( $sql );
      $db = null; // clear db object
      
      return $response->withStatus(200);
        
    } 
    catch( PDOException $e ) {
      // show error message as Json format
      return $response->withJson([
        "error" => [
            "msg" => $e->getMessage(),
        ]], 400);
    }

})->add( new ValidationPutQuantityMiddleware());

$app->put('/teachaway/{type}/increase/{id}', function  (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {

    try {
      $db = new db();
      $db = $db->connect($this->get('settings')["db"]);

      $stmt = $db->query( "select id from ".$args["type"]." where id = ".$args["id"].";");
      $result = $stmt->fetch( PDO::FETCH_OBJ );
      
      if (!$result){
          return $response->withStatus(404);
      }

      $sql = "UPDATE ".$args["type"]."
      SET count=count + ".$request->getParam('quantity')."
      WHERE id=".$args["id"].";";

      $stmt = $db->exec( $sql );
      $db = null; // clear db object
      
      return $response->withStatus(200);
        
    } 
    catch( PDOException $e ) {
      // show error message as Json format
      return $response->withJson([
        "error" => [
            "msg" => $e->getMessage(),
        ]], 400);
    }

})->add( new ValidationPutIncDecMiddleware());

$app->put('/teachaway/{type}/decrease/{id}', function  (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {

    try {

      $db = new db();
      $db = $db->connect($this->get('settings')["db"]);

      $stmt = $db->query( "select id from ".$args["type"]." where id = ".$args["id"].";");
      $result = $stmt->fetch( PDO::FETCH_OBJ );
      
      if (!$result){
          return $response->withStatus(404);
      }

      $sql = "UPDATE ".$args["type"]."
      SET count=count - ".$request->getParam('quantity')."
      WHERE id=".$args["id"].";";

      $stmt = $db->exec( $sql );
      $db = null; // clear db object
      
      return $response->withStatus(200);
        
    } 
    catch( PDOException $e ) {
      // show error message as Json format
      return $response->withJson([
        "error" => [
            "msg" => $e->getMessage(),
        ]], 400);
    }

})->add( new ValidationPutIncDecMiddleware());

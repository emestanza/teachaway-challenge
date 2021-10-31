<?php

// # include the Slim framework
require __DIR__ . '/../vendor/autoload.php';

// # use Namespaces for HTTP request
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// # include DB connection file
require __DIR__ .'/../src/app/app.php';
require __DIR__ .'/../src/config/db.php';


// # allow to get the total number of units for a specific vehicle
$app->get('/teachaway/vehicle/{name}', function  (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {

    $sql = "SELECT count
    FROM vehicle
    WHERE UPPER(name) = UPPER('".$args["name"]."');";

    try {

      $db = new db();
      $db = $db->connect($this->get('settings')["db"]);
  
      // query
      $stmt = $db->query( $sql );
     
      //$arts = $stmt->fetchAll( PDO::FETCH_OBJ );
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
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
        ]], 404);
    }

});


// # allow to get the total number of units for a specific starship
$app->get('/teachaway/starship/{name}', function  (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {

    $sql = "SELECT count
    FROM starship
    WHERE UPPER(name) = UPPER('".$args["name"]."');";

    try {

      $db = new db();
      $db = $db->connect($this->get('settings')["db"]);
  
      // query
      $stmt = $db->query( $sql );
     
      //$arts = $stmt->fetchAll( PDO::FETCH_OBJ );
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
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
        ]], 404);
    }

});



// # let Slim starts to run
// without run(), the api routes won't work
$app->run();
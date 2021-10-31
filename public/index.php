<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ .'/../src/app/app.php';
require __DIR__ .'/../src/config/db.php';
require __DIR__ .'/../src/app/validation.php';

// # allow to get the total number of units for a specific vehicle or starship
$app->get('/teachaway/{type}/{name}', function  (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {

    $sql = "SELECT count
    FROM ".$args["type"]."
    WHERE UPPER(name) = UPPER('".$args["name"]."');";

    try {
      validate($args);
      $db = new db();
      $db = $db->connect($this->get('settings')["db"]);
  
      // query
      $stmt = $db->query( $sql );
     
      //$arts = $stmt->fetchAll( PDO::FETCH_OBJ );
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $db = null; // clear db object

      if (!$result){
          return $response->withStatus(400);
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
    catch( ValidationException $e ) {
        return $response->withJson([
          "error" => [
            $e->errorMessage(),
          ]], 400);
      }

});


// # let Slim starts to run
// without run(), the api routes won't work
$app->run();
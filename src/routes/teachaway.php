<?php
require __DIR__ .'/../middleware/ValidationGetInfoMiddleware.php';
require __DIR__ .'/../middleware/ValidationPutQuantityMiddleware.php';
require __DIR__ .'/../middleware/ValidationPutIncDecMiddleware.php';

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

// # Capturing bad routes
$app->get('/[{path:.*}]', function  (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
 
    return $response->withJson(array("message" => "Bad Route: Check README.md")
        , 400);

});

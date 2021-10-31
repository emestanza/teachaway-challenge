<?php


// # allow to get the total number of units for a specific vehicle or starship
$app->get('/teachaway/{type}/{name}', function  (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {

    $sql = "SELECT id, name, count
    FROM ".$args["type"]."
    WHERE UPPER(name) like CONCAT('%', '".$args["name"]."', '%');";

    try {
      validate($args);
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
    catch( ValidationException $e ) {
        return $response->withJson([
          "error" => [
            $e->errorMessage(),
          ]], 400);
      }

});

// # allow to set the total number of units for a specific vehicle or starship
$app->put('/teachaway/{type}/{id}', function  (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {

    try {
      validatePutForSet(array_merge($args, $request->getParams()));

      $sql = "UPDATE ".$args["type"]."
      SET count=".$request->getParam('quantity')."
      WHERE id=".$args["id"].";";

      $db = new db();
      $db = $db->connect($this->get('settings')["db"]);
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
    catch( ValidationException $e ) {
        return $response->withJson([
          "error" => [
            $e->errorMessage(),
          ]], 400);
      }

});

$app->put('/teachaway/{type}/increase/{id}', function  (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {

    try {
      validatePutForIncrease(array_merge($args, $request->getParams()));

      $sql = "UPDATE ".$args["type"]."
      SET count=count + ".$request->getParam('quantity')."
      WHERE id=".$args["id"].";";

      $db = new db();
      $db = $db->connect($this->get('settings')["db"]);
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
    catch( ValidationException $e ) {
        return $response->withJson([
          "error" => [
            $e->errorMessage(),
          ]], 400);
      }

});

$app->put('/teachaway/{type}/decrease/{id}', function  (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {

    try {
      validatePutForIncrease(array_merge($args, $request->getParams()));

      $sql = "UPDATE ".$args["type"]."
      SET count=count - ".$request->getParam('quantity')."
      WHERE id=".$args["id"].";";

      $db = new db();
      $db = $db->connect($this->get('settings')["db"]);
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
    catch( ValidationException $e ) {
        return $response->withJson([
          "error" => [
            $e->errorMessage(),
          ]], 400);
      }

});

// # Capturing bad routes
$app->get('/[{path:.*}]', function  (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
 
    return $response->withJson(array("message" => "Bad Route: Check README.md")
        , 400);

});

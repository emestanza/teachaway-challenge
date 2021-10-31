<?php
/**
 * Connect MySQL with PDO class
 */
class db {

  public function connect($db) {

    //db = $container->get('settings')['db'];
    $host = $db['host'];
    $name = $db['name'];
    $user = $db['user'];
    $pass = $db['pass'];
    $port = $db['port'];

    // https://www.php.net/manual/en/pdo.connections.php
    $dbConn = new PDO("mysql:host=${host};port=$port;charset=utf8", $user, $pass);

    // https://www.php.net/manual/en/pdo.setattribute.php
    $dbConn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $dbConn->exec("USE ${name}");
    // return the database connection back
    return $dbConn;
  }
}
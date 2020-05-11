<?php

require("kitweb_v2_db_production.php");

class PdoWrapper {
  private $host;
  private $user;
  private $password;

  public function __construct() {
    $this->host = $GLOBALS['dbHost'];
    $this->user = $GLOBALS['dbUser'];
    $this->password = $GLOBALS['dbPassword'];
  }
  
  function getConnection() {
    try {
      $dbh = new PDO($this->host, $this->user, $this->password,
                     [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                       PDO::ATTR_EMULATE_PREPARES, false,
                       PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ]);
      return $dbh;
    } catch (PDOException $e) {
      print("Error " . $e->getMessage() . "<br>");
      die();
    }
  }
}

function getdbh() {
    return (new PdoWrapper())->getConnection();
}

<?php

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'rrperfume-shop-db');

class DatabaseConnectionService
{
  protected $dbConn;

  public function createDBConnection()
  {
    $this->dbConn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    return $this->dbConn;
  }

  public function closeDBConnection()
  {
    mysqli_close($this->dbConn);
  }
}
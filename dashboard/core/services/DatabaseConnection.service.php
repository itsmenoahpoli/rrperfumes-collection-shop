<?php



class DatabaseConnectionService
{
  protected $dbConn;

  public function createDBConnection()
  {
    /**
     * DATABASE PROPERTIES
     */
    $dbHost = '127.0.0.1';
    $dbUser = 'root';
    $dbPassword = '';
    $dbName = 'rrperfume-shop-db';

    $this->dbConn = mysqli_connect($dbHost, $dbUser, $dbPassword, $dbName);

    return $this->dbConn;
  }

  public function closeDBConnection()
  {
    mysqli_close($this->dbConn);
  }
}
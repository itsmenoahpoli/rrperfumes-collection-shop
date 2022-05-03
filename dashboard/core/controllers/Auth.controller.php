<?php
require __DIR__.'./../services/DatabaseConnection.service.php';
require __DIR__.'./../response/Http.response.php';

class AuthController extends DatabaseConnectionService
{
  protected $dbConn;
  public $httpResponse;

  public function __construct()
  {
    $this->dbConn = $this->createDBConnection();
    $this->httpResponse = new HttpResponse();
  }

  public function userLogin($credentials)
  {
    try 
    {
      $userInputPassword = md5($credentials->password);
    
      $loginQry = "SELECT * FROM users WHERE email = '{$credentials->email}' AND password = '{$userInputPassword}'";
      $loginQryResult = $this->dbConn->query($loginQry);

      if ($loginQryResult->num_rows > 0)
      {
        while($user = $loginQryResult->fetch_assoc())
        {
          return $this->httpResponse->send($user, 200);
        }
      }
      

      return $this->httpResponse->send("Unauthorized", 401);
    } catch (Exception $e)
    {
      return $this->httpResponse->send($e->getMessage(), 500);
    }
  }

  public function userRegister($user)
  {
    return $this->httpResponse->send('Registered', 201);
  }

  public function userVerify($user)
  {
    return $this->httpResponse->send('Verify User', 200);
  }

  public function userResetPassword($user)
  {
    return $this->httpResponse->send('Reset password', 200);
  }
}
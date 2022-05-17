<?php
require __DIR__.'./../services/DatabaseConnection.service.php';
require __DIR__.'./../response/Http.response.php';

require __DIR__.'./../services/Mail.service.php';

class MailsController extends DatabaseConnectionService
{
  protected $dbConn;
  public $httpResponse;
  public $mailService;

  public function __construct()
  {
    $this->dbConn = $this->createDBConnection();
    $this->httpResponse = new HttpResponse();
    $this->mailService = new MailService();
  }

  public function testMail()
  {
    try 
    {
      return $this->httpResponse->send(
        $this->mailService->sendMail(),
        200
      );
    } catch (Exception $e)
    {
      return $this->httpResponse->send($e->getMessage, 500);
    }
  }
}
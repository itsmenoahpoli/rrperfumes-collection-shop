<?php
require __DIR__.'./../../controllers/Mails.controller.php';

header('Access-Control-Allow-Origin *');
header('Content-Type: application/json');

$mailsController = new MailsController();
$request = file_get_contents("php://input");

$request = json_decode($request);

$requestFnName = $request->fnName;

switch ($requestFnName)
{
  case 'mails-testMail':
    return $mailsController->testMail($request);

  default:
    return 'Invalid Request';
}
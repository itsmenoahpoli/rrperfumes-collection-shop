<?php
require __DIR__.'./../../controllers/Auth.controller.php';

header('Access-Control-Allow-Origin *');
header('Content-Type: application/json');

$authController = new AuthController();
$request = file_get_contents("php://input");
$request = json_decode($request);

$requestFnName = $request->fnName;

switch ($requestFnName)
{
  case 'user-login':
    return $authController->userLogin($request);

  case 'user-register':
    return $authController->userRegister($request);

  
  case 'user-verify':
    return $authController->userVerify($request);

    
  case 'user-reset-password':
    return $authController->userResetPassword($request);

  default:
    return 'Invalid Request';
}
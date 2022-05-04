<?php
require __DIR__.'./../../controllers/Orders.controller.php';

header('Access-Control-Allow-Origin *');
header('Content-Type: application/json');

$ordersController = new OrdersController();
$request = file_get_contents("php://input");
$request = json_decode($request);

$requestFnName = $request->fnName;

switch ($requestFnName)
{
  case 'orders-getAll':
    return $ordersController->getAll($request);

  case 'product-create':
    return $ordersController->create($request);

  case 'orders-getById':
    return $ordersController->getById($request);

  case 'orders-updateById':
    return $ordersController->updateById($request);

  case 'orders-deleteById':
    return $ordersController->deleteById($request);

  default:
    return 'Invalid Request';
}
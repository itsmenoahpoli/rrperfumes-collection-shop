<?php
require __DIR__.'./../../controllers/Products.controller.php';

header('Access-Control-Allow-Origin *');
header('Content-Type: application/json');

$productsController = new ProductsController();
$request = file_get_contents("php://input");
$request = json_decode($request);

$requestFnName = $request->fnName;

switch ($requestFnName)
{
  case 'products-getAll':
    return $productsController->getAll($request);

  case 'product-create':
    return $productsController->create($request);

  case 'products-getById':
    return $productsController->getById($request);

  case 'products-updateById':
    return $productsController->updateById($request);

  case 'products-deleteById':
    return $productsController->deleteById($request);

  default:
    return 'Invalid Request';
}
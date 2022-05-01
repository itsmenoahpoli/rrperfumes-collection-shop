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
  case 'product-create':
    return $productsController->productCreate($request);

  case 'products-getAll':
    return $productsController->productsGetAll($request);

  case 'products-getById':
    return $productsController->productsGetById($request);

  case 'products-update':
    return $productsController->productsUpdate($request);

  case 'products-delete':
    return $productsController->productsDelete($request);

  default:
    return 'Invalid Request';
}
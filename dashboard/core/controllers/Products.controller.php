<?php
require __DIR__.'./../services/DatabaseConnection.service.php';
require __DIR__.'./../response/Http.response.php';

class ProductsController extends DatabaseConnectionService
{
  protected $dbConn;
  public $httpResponse;

  public function __construct()
  {
    $this->dbConn = $this->createDBConnection();
    $this->httpResponse = new HttpResponse();
  }

  public function generateSKU()
  {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 10; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return strtoupper('SKU-'.$randomString);
  }

  public function productsGetAll()
  {
    try 
    {
      $productsGetAllQry = "SELECT * FROM `products` ORDER BY created_at DESC";
      $productsGetAllQryResult = $this->dbConn->query($productsGetAllQry);

      if ($productsGetAllQryResult->num_rows > 0)
      {
        while ($products = $productsGetAllQryResult->fetch_assoc())
        {
          $productsArr[] = $products;
        }

        return $this->httpResponse->send($productsArr);
      }
    } catch (Exception $e)
    {
      return $this->httpResponse->send($e->getMessage(), 500);
    }
  }

  public function productGetById($product)
  {
    try
    {
      $productGetByIdQry = "SELECT * FROM `products` WHERE id = {$product->id}";
      $productGetByIdQryResult = $this->dbConn->query($productGetByIdQry);

      if ($productGetByIdQryResult->num_rows > 0)
      {
        while ($product = $productGetByIdQryResult->fetch_assoc())
        {
          return $this->httpResponse->send($product);
        }
      }
    } catch (Exception $e)
    {
      return $this->httpResponse->send($e->getMessage(), 500);
    }
  }

  public function productCreate($product)
  {
    try 
    {
      $productSKU = $this->generateSKU();

      $productCreateQry = "
        INSERT INTO `products` (sku, category, name, description, price, quantity)
        VALUES ('{$productSKU}', '{$product->category}', '{$product->name}', '{$product->description}', '{$product->price}', '{$product->quantity}')
      ";

      if (mysqli_query($this->dbConn, $productCreateQry)) {
        return $this->httpResponse->send('Product uploaded', 201);
      }

      return $this->httpResponse->send(mysqli_error($this->dbConn));
    } catch (Exception $e)
    {
      return $this->httpResponse->send($e->getMessage(), 500);
    }
  }

  public function productUpdate($product)
  {
    try
    {
      $productUpdateQry = "
      UPDATE `products` 
      SET category = '{$product->category}',  name = '{$product->name}', description = '{$product->description}', quantity = '{$product->quantity}', price = '{$product->price}', 
      WHERE id = {$product->id}
    ";

    if (mysqli_query($this->dbConn, $productUpdateQry)) {
      return $this->httpResponse->send('Product uploaded', 201);
    }

    return $this->httpResponse->send(mysqli_error($this->dbConn));
    } catch (Exception $e)
    {
      return $this->httpResponse->send($e->getMessage(), 500);
    }
  }

  public function productDelete($product)
  {
    try
    {
      $productDeleteByIdQry = "DELETE FROM `products` WHERE id = {$product->id}";
      $productDeleteByIdQryResult = $this->dbConn->query($productDeleteByIdQry);

      if ($dbConn->query($productDeleteByIdQry))
      {
        return $this->httpResponse->send(NULL, 204);
      }
    } catch (Exception $e)
    {
      return $this->httpResponse->send($e->getMessage(), 500);
    }
  }
}
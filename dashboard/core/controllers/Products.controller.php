<?php
require __DIR__.'./../services/DatabaseConnection.service.php';
require __DIR__.'./../response/Http.response.php';

class ProductsController extends DatabaseConnectionService
{
  protected $dbConn;
  protected $dbTable = 'products';
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

  public function getAll($request)
  {
    try 
    {
      $productsGetAllQry = "SELECT * FROM `{$this->dbTable}` WHERE name LIKE '%{$request->q}' OR description LIKE '%{$request->q}%' ORDER BY created_at DESC";
      $productsGetAllQryResult = $this->dbConn->query($productsGetAllQry);

      if ($productsGetAllQryResult->num_rows > 0)
      {
        while ($products = $productsGetAllQryResult->fetch_assoc())
        {
          $productsArr[] = $products;
        }

        return $this->httpResponse->send($productsArr);
      }

      // if (!$productsGetAllQryResult->num_rows > 0)
      // {
      //   return $this->httpResponse->send([], 404);
      // }
    } catch (Exception $e)
    {
      return $this->httpResponse->send($e->getMessage(), 500);
    }
  }

  public function getById($request)
  {
    try
    {
      $productGetByIdQry = "SELECT * FROM `{$this->dbTable}` WHERE id = {$request->id}";
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

  public function create($request)
  {
    try 
    {
      $productSKU = $this->generateSKU();

      $productCreateQry = "
        INSERT INTO `{$this->dbTable}` (sku, category, name, description, price, quantity)
        VALUES ('{$productSKU}', '{$request->category}', '{$request->name}', '{$request->description}', '{$request->price}', '{$request->quantity}')
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

  public function updateById($request)
  {
    try
    {
      $productUpdateQry = "
      UPDATE `{$this->dbTable}` 
      SET category = '{$request->category}',  name = '{$request->name}', description = '{$request->description}', quantity = '{$request->quantity}', price = '{$request->price}' 
      WHERE id = {$request->id}
    ";

    if (mysqli_query($this->dbConn, $productUpdateQry)) {
      return $this->httpResponse->send('Product updated', 200);
    }

    return $this->httpResponse->send(mysqli_error($this->dbConn));
    } catch (Exception $e)
    {
      return $this->httpResponse->send($e->getMessage(), 500);
    }
  }

  public function deleteById($request)
  {
    try
    {
      $productDeleteByIdQry = "DELETE FROM `{$this->dbTable}` WHERE id = {$request->id}";
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
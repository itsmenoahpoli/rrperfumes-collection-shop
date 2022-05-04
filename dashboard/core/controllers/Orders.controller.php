<?php
require __DIR__.'./../services/DatabaseConnection.service.php';
require __DIR__.'./../response/Http.response.php';

class OrdersController extends DatabaseConnectionService
{
  protected $dbConn;
  protected $dbTable = 'orders';
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
      $GetAllQry = "SELECT * FROM `{$this->dbTable}` WHERE name LIKE '%{$request->q}' OR description LIKE '%{$request->q}%' ORDER BY created_at DESC";
      $GetAllQryResult = $this->dbConn->query($GetAllQry);

      if ($GetAllQryResult->num_rows > 0)
      {
        while ($orders = $GetAllQryResult->fetch_assoc())
        {
          $ordersArr[] = $orders;
        }

        return $this->httpResponse->send($ordersArr);
      }

      // if (!$GetAllQryResult->num_rows > 0)
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
      $GetByIdQry = "SELECT * FROM `{$this->dbTable}` WHERE id = {$request->id}";
      $GetByIdQryResult = $this->dbConn->query($GetByIdQry);

      if ($GetByIdQryResult->num_rows > 0)
      {
        while ($orders = $GetByIdQryResult->fetch_assoc())
        {
          return $this->httpResponse->send($orders);
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
      $KU = $this->generateSKU();

      $CreateQry = "
        INSERT INTO `{$this->dbTable}` ()
        VALUES ()
      ";

      if (mysqli_query($this->dbConn, $CreateQry)) {
        return $this->httpResponse->send(' uploaded', 201);
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
      $UpdateQry = "
      UPDATE `{$this->dbTable}` 
      SET  
      WHERE id = {$request->id}
    ";

    if (mysqli_query($this->dbConn, $UpdateQry)) {
      return $this->httpResponse->send(' updated', 200);
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
      $DeleteByIdQry = "DELETE FROM `{$this->dbTable}` WHERE id = {$request->id}";
      $DeleteByIdQryResult = $this->dbConn->query($DeleteByIdQry);

      if ($dbConn->query($DeleteByIdQry))
      {
        return $this->httpResponse->send(NULL, 204);
      }
    } catch (Exception $e)
    {
      return $this->httpResponse->send($e->getMessage(), 500);
    }
  }
}
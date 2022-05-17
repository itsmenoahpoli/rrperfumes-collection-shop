<?php
require __DIR__.'./../services/DatabaseConnection.service.php';
require __DIR__.'./../services/Mail.service.php';
require __DIR__.'./../response/Http.response.php';

class OrdersController extends DatabaseConnectionService
{
  protected $dbConn;
  protected $dbTable = 'orders';
  public $httpResponse;
  public $mailService;

  public function __construct()
  {
    $this->dbConn = $this->createDBConnection();
    $this->httpResponse = new HttpResponse();
    $this->mailService = new MailService();
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
      $GetAllQry = "SELECT * FROM `{$this->dbTable}` WHERE reference_code LIKE '%{$request->q}' OR customer_name LIKE '%{$request->q}%' OR customer_email LIKE '%{$request->q}%' OR customer_contacts LIKE '%{$request->q}%' OR status LIKE '%{$request->q}%'  ORDER BY created_at DESC";
      $GetAllQryResult = $this->dbConn->query($GetAllQry);

      if ($GetAllQryResult->num_rows > 0)
      {
        while ($orders = $GetAllQryResult->fetch_assoc())
        {
          $ordersArr[] = $orders;
        }

        return $this->httpResponse->send($ordersArr);
      }
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

  public function getByRefCode($request)
  {
    try
    {
      $GetByRefCodeQry = "SELECT * FROM `{$this->dbTable}` WHERE reference_code = '{$request->reference_code}'";
      $GetByRefCodeQryResult = $this->dbConn->query($GetByRefCodeQry);

      if ($GetByRefCodeQryResult->num_rows > 0)
      {
        while ($orders = $GetByRefCodeQryResult->fetch_assoc())
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

  public function updateByRefCode($request)
  {
    try
    {
      $UpdateQry = "
      UPDATE `{$this->dbTable}` 
      SET  status = '{$request->status}'
      WHERE reference_code = '{$request->reference_code}'
    ";

    if (mysqli_query($this->dbConn, $UpdateQry)) {
      $orderStatusMailTemplate = <<<EOD
        <html>
          <body>
            <h4>Greetings customer,</h4> 

            <p>
              Order Reference #: {$request->reference_code}
            </p>

            <p>
              Were happy to inform you that the status of your order <br />
              has been updated to ({$request->status})
            </p>
          </body>
        </html>
      EOD;

      $this->mailService->sendMail([
        'subject' => 'Order Status Update',
        'to' => "patrickpolicarpio08@gmail.com",
        'message' => $orderStatusMailTemplate,
      ]);

      return $this->httpResponse->send(' updated', 200);
    }

    return $this->httpResponse->send(mysqli_error($this->dbConn));
    } catch (Exception $e)
    {
      return $this->httpResponse->send($e->getMessage(), 500);
    }
  }

  public function updateById($request)
  {
    var_dump($request);
    try
    {
      $UpdateQry = "
      UPDATE `{$this->dbTable}` 
      SET  status = '{$request->status}'
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
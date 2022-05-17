<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__.'./../../../vendor/autoload.php';

class MailService 
{
  protected $mail;
  protected $mailtrapConfig;

  public function __construct()
  {
    $this->mail = new PHPMailer(true);
    $this->mailtrapConfig = (object) [
      'SMTP_USERNAME' => '8169a9e5354a61',
      'SMTP_PASSWORD' => 'dca326ea5f3b2d',
    ];
  }

  public function sendMail(array $mail)
  {
    try 
    {
      $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
      $this->mail->isSMTP();
      $this->mail->Host = 'smtp.mailtrap.io';
      $this->mail->SMTPAuth = true;
      $this->mail->Port = 2525;
      $this->mail->Username = $this->mailtrapConfig->SMTP_USERNAME;
      $this->mail->Password = $this->mailtrapConfig->SMTP_PASSWORD;
      
      $this->mail->setFrom('no-reply@rrperfumes.com');
      $this->mail->addAddress($mail['to']);

      $this->mail->Subject = "RR Perfumes & Collections - {$mail['subject']}";

      $this->mail->isHTML(true);
      $this->mail->Body = <<<EOD
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Document</title>
        </head>
        <body>
          <p>
            {$mail['message']}
          </p>
        </body>
        </html>
      EOD;

      $this->mail->AltBody = $mail['message'];
      $this->mail->send();

      return "E-mail notification successfully sent to {$mail['to']}";
    } catch (Exception $e) 
    {
      throw $e->getMessage();
    }
  }
}
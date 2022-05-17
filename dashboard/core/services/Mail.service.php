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

  public function sendMail()
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
      $this->mail->addAddress('johndoe@domain.com');

      $this->mail->Subject = ('Test e-mail message from RR Perfumes & Collection');

      $this->mail->isHTML(true);
      $this->mail->Body = '<p>This is a test e-mail</p>';
      $this->mail->AltBody = 'This is a test e-mail';

      $this->mail->send();

      return 'E-mail sent successfully';
    } catch (Exception $e) 
    {
      throw $e->getMessage();
    }
  }
}
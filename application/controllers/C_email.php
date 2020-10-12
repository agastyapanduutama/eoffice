<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class C_email extends CI_Controller {

	public function __construct() { 
                parent::__construct(); 
                
                require APPPATH.'libraries/phpmailer/src/Exception.php';
                require APPPATH.'libraries/phpmailer/src/PHPMailer.php';
                require APPPATH.'libraries/phpmailer/src/SMTP.php';
                 
                    }
                    function index() 
                    {

                        // PHPMailer object
                     $response = false;
                     $mail = new PHPMailer();
                   
            
                    // SMTP configuration
                    $mail->isSMTP();
                    $mail->Host     = 'smtp.gmail.com'; //sesuaikan sesuai nama domain hosting/server yang digunakan
                    $mail->SMTPAuth = true;
                    $mail->Username = 'suksesdianglobaltech@gmail.com'; // user email
                    $mail->Password = 'suksespasti123'; // password email
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port     = 465;
            
                    $mail->setFrom('suksesdianglobaltech@gmail.com', ''); // user email
                    // $mail->addReplyTo('xxx@hostdomain.com', ''); //user email
            
                    // Add a recipient
                    $mail->addAddress('agastypandu@gmail.com'); //email tujuan pengiriman email
            
                    // Email subject
                    $mail->Subject = 'Surat Masuk'; //subject email
            
                    // Set email format to HTML
                    $mail->isHTML(true);
            
                    // Email body content
                    $mailContent = $this->load->view('email',[], TRUE);
                    // "<h1>SMTP Codeigniterr</h1>
                    // <p>Laporan email SMTP Codeigniter.</p>"; 
                    // isi email


                    $mail->Body = $mailContent;
            
                    // Send email
                    if(!$mail->send()){
                        echo 'Message could not be sent.';
                        echo 'Mailer Error: ' . $mail->ErrorInfo;
                    }else{
                        echo 'Message has been sent';
                    }
                }

    function design()
    {
        $this->load->view('email');
    }

}


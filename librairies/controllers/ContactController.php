<?php

namespace Controllers;

require_once 'librairies/autoload.php';

require 'vendor/PHPMailer/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/PHPMailer/src/SMTP.php';

use Classes\Contact;
use Notification;
use Http;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class ContactController extends Controller
{
    protected $modelName = \Models\ContactModel::class;
    private const HOST = 'xxx';
    private const USERNAME = 'xxx';
    private const PASSWORD = 'xxx';
    private const PORT = 465;


    public function check()
    {
        $firstname = null;
        if (!empty($_POST['firstname'])) {
            $firstname = $_POST['firstname'];
        }

        $lastname = null;
        if (!empty($_POST['lastname'])) {
            $lastname = $_POST['lastname'];
        }

        $email = null;
        if (!empty($_POST['email'])) {
            $email = $_POST['email'];
        }

        $message = null;
        if (!empty($_POST['message'])) {
            $message = $_POST['message'];
        }

        if (!$firstname || !$lastname || !$email || !$message) {
            Notification::set('error', "Tous les champs du formulaire doivent être remplis.");
            Http::redirect('/');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Notification::set('error', "L'adresse email saisie n'est pas valide.");
            Http::redirect('/');
        }

        $contact = (new Contact())
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setEmail($email)
            ->setMessage($message);

        // Send email
        $this->send($contact);

        // Rec email in DB
        $this->model->insert($contact);

        Notification::set('success', "Merci pour votre message ! :) Il a bien été envoyé et je vous répondrai sous peu.");
        Http::redirect("/");
    }

    public function send(Contact $contact)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = self::HOST;                             //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = self::USERNAME;                         //SMTP username
            $mail->Password   = self::PASSWORD;                         //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = self::PORT;                             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('address@domain.com', 'xxx');
            $mail->addAddress('address@domain.com', 'xxx');
            $mail->addReplyTo($contact->getEmail(), $contact->getFirstname() . ' ' . $contact->getLastname());

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Formulaire de contact';
            $mail->Body    = $contact->getMessage();
            $mail->AltBody = $contact->getMessage();

            $mail->send();

        } catch (Exception $e) {
            Notification::set('error', "Le message n'a pas pu être envoyé pour la raison suivante : $mail->ErrorInfo");
            Http::redirect("/");
        }
    }
}
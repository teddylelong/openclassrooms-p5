<?php

namespace Controllers;

use Entities\Contact;
use Models\ContactModel;
use Notification;
use Http;
use Renderer;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class ContactController extends Controller
{
    protected ContactModel $contactModel;

    private const HOST      = 'xxx';
    private const USERNAME  = 'xxx';
    private const PASSWORD  = 'xxx';
    private const PORT      = 465;

    public function __construct()
    {
        parent::__construct();
        $this->contactModel = new ContactModel();
    }

    /**
     * Display the contact form
     *
     * @return void
     */
    public function contact()
    {
        $pageTitle = "Me contacter";
        $this->renderer->render('contact/contact', compact('pageTitle'));
    }

    /**
     * Check data in contact form, send email and save it in database
     *
     * @return void
     */
    public function check()
    {
        $firstname = filter_input(INPUT_POST, 'firstname');
        if (empty($firstname)) {
            $firstname = null;
        }

        $lastname = filter_input(INPUT_POST, 'lastname');
        if (empty($lastname)) {
            $lastname = null;
        }

        $email = filter_input(INPUT_POST, 'email');
        if (empty($email)) {
            $email = null;
        }

        $message = filter_input(INPUT_POST, 'message');
        if (empty($message)) {
            $message = null;
        }

        if (!$firstname || !$lastname || !$email || !$message) {
            Notification::set('error', "Tous les champs du formulaire doivent être remplis.");
            $this->http->redirect('/contact/');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Notification::set('error', "L'adresse email saisie n'est pas valide.");
            $this->http->redirect('/contact/');
        }

        $contact = (new Contact())
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setEmail($email)
            ->setMessage($message);

        // Send email
        $this->send($contact);

        // Rec email in DB
        $this->contactModel->insert($contact);

        Notification::set('success', "Merci pour votre message ! :) Il a bien été envoyé et je vous répondrai sous peu.");
        $this->http->redirect('/contact/');
    }

    /**
     * Send a mail with PHP mailer
     *
     * @param Contact $contact
     * @return void
     */
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
            $this->http->redirect("/contact/");
        }
    }
}
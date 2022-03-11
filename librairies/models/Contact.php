<?php

namespace Models;

require_once 'librairies/autoload.php';

class Contact extends Model
{
    protected $table = 'contact';

    public function insert(\Classes\Contact $contact): void
    {
        $query = $this->pdo->prepare('INSERT INTO contact SET firstname = :firstname, lastname = :lastname, email = :email, message = :message');
        $query->execute([
            'firstname' => $contact->getFirstname(),
            'lastname' => $contact->getLastname(),
            'email' => $contact->getEmail(),
            'message' => $contact->getMessage()
        ]);
    }
}
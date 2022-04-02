<?php

namespace Models;

use Entities\Contact;

class ContactModel extends Model
{
    protected $table = 'contact';

    /**
     * Insert a new contact request in database
     * @param Contact $contact
     * @return void
     */
    public function insert(Contact $contact): void
    {
        $query = $this->pdo->prepare('INSERT INTO contact SET firstname = :firstname, lastname = :lastname, email = :email, message = :message');
        $query->execute([
            'firstname' => $contact->getFirstname(),
            'lastname'  => $contact->getLastname(),
            'email'     => $contact->getEmail(),
            'message'   => $contact->getMessage()
        ]);
    }
}
<?php

namespace App\Repository;

use App\Entity\Contact;
use \PDO;
class TableContact
{
    private $bdd;
    private $Tidentifiant;

    /**
     * @param $bdd
     */
    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
        $this->Tidentifiant = new TableIdentifiant($this->bdd);
    }
    public function getAllContact()
    {
        $req = $this->bdd->query("SELECT contact.* , identifiant.nom , identifiant.prenom , identifiant.adress_email FROM contact
        LEFT JOIN identifiant ON contact.identifiant_id = identifiant.id");
        $req->setFetchMode(PDO::FETCH_CLASS, Contact::class);
        return $req->fetchAll();
    }

    /**
     * @param Contact $contact
     * @return void hydrate identifiant_id de l'object
     * @throws \Exception
     */
    public function addContact(Contact $contact)
    {
        $data = $this->isEmailExite($contact);

        if($data)
        {
            $contact->setIdentifiantId($data['id']);
            $contact->setPrenom($data['prenom']);
        }else{
            $id =   $this->Tidentifiant->addIdentifiant($contact->getNom(),$contact->getAdressEmail());
            $contact->setIdentifiantId($id);
        }
        $req = $this->bdd->prepare("INSERT INTO contact SET identifiant_id = :identifiant , numero_telephone = :tel , message = :message");
        $req->bindValue('identifiant',$contact->getIdentifiantId(),PDO::PARAM_INT);
        $req->bindValue('tel',$contact->getNumeroTelephone(),PDO::PARAM_INT);
        $req->bindValue('message',$contact->getMessage(),PDO::PARAM_STR);
        $req->execute();
        if(!$req){throw  new \Exception("insertion contact n'a pas réussit !!!");}
    }
    public function isEmailExite(Contact $contact)
    {
        return $this->Tidentifiant->isEmailExite($contact->getAdressEmail());

    }


}
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
            $id =   $this->Tidentifiant->addIdentifiant($contact->getNom(),$contact->getAdressEmail(),$contact->getPrenom());
            $contact->setIdentifiantId($id);
        }
        $req = $this->bdd->prepare("INSERT INTO contact SET identifiant_id = :identifiant , numero_telephone = :tel , message = :message, etat = :etat");
        $req->bindValue('identifiant',$contact->getIdentifiantId(),PDO::PARAM_INT);
        $req->bindValue('tel',$contact->getNumeroTelephone(),PDO::PARAM_INT);
        $req->bindValue('message',$contact->getMessage(),PDO::PARAM_STR);
        $req->bindValue('etat',$contact->getEtat(),PDO::PARAM_STR);
        $req->execute();
        if(!$req){throw  new \Exception("insertion contact n'a pas réussit !!!");}
    }
    public function isEmailExite(Contact $contact)
    {
        return $this->Tidentifiant->isEmailExite($contact->getAdressEmail());

    }
    public function getContactById(int $id):Contact
    {
        $query = "SELECT contact.id ,contact.numero_telephone, contact.etat,contact.message , contact.identifiant_id ,identifiant.nom , identifiant.adress_email , identifiant.prenom 
                FROM contact
                LEFT JOIN identifiant ON identifiant_id = identifiant.id
                WHERE contact.id= :id ";
        $req = $this->bdd->prepare($query);
        $req->bindValue('id',$id,PDO::PARAM_INT);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, Contact::class);
        return $req->fetch();
    }
    public function updateContact( Contact $contact)
    {
        $query ="UPDATE contact SET etat= :etat WHERE id = :id";
        $req = $this->bdd->prepare($query);
        $req->bindValue('id',$contact->getId(),PDO::PARAM_INT);
        $req->bindValue('etat', $contact->getEtat(),PDO::PARAM_STR);
        $req->execute();

    }
    public function getCountNewContact()
    {
        $query = "SELECT count(id) FROM contact WHERE etat = :nouveau";
        $req = $this->bdd->prepare($query);
        $req->bindValue('nouveau','nouveau',PDO::PARAM_STR);
        $req->execute();
        return $req->fetchColumn();
    }
    public function deleteContact(Contact $contact)
    {
        $req = $this->bdd->query("DELETE FROM contact WHERE id = {$contact->getId()} LIMIT 1");
    }
    public function isContactExite(int $id):bool
    {
        $query = "SELECT COUNT(*) FROM contact WHERE id = ?";
        $req = $this->bdd->prepare($query);
        $req->execute([$id]);
        return (bool) $req->fetchColumn();
    }


}
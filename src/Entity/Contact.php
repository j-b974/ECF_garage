<?php

namespace App\Entity;

class contact
{
    protected $id;
    protected $identifiant_id;
    protected $numero_telephone;

    protected $message;
    protected $prenom;
    protected $nom;
    protected $adress_email;

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return contact
     */
    public function setId($id):self
    {
        $this->id = (int) $id;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdentifiantId():int
    {
        return $this->identifiant_id;
    }

    /**
     * @param mixed $identifiant_id
     * @return contact
     */
    public function setIdentifiantId($identifiant_id):self
    {
        $this->identifiant_id =(int) $identifiant_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getNumeroTelephone():int
    {
        return $this->numero_telephone;
    }

    /**
     * @param midex $numero_telephone
     * @return contact
     */
    public function setNumeroTelephone($numero_telephone):self
    {
        $this->numero_telephone =(int) $numero_telephone;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage():string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return contact
     */
    public function setMessage(string $message):self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     * @return contact
     */
    public function setPrenom(?string $prenom):self
    {
        if($prenom){$this->prenom = $prenom;}
        return $this;
    }

    /**
     * @return string
     */
    public function getNom():string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return contact
     */
    public function setNom(string $nom):self
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdressEmail():string
    {
        return $this->adress_email;
    }

    /**
     * @param string $adress_email
     * @return contact
     */
    public function setAdressEmail(string $adress_email):self
    {
        $this->adress_email = $adress_email;
        return $this;
    }


}
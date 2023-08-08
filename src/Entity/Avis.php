<?php

namespace App\Entity;

class Avis
{
    protected  $id;
    protected $identifiant_id;
    protected $commentaire;

    protected $note=1;

    protected $nom;
    protected $adress_email;

    /**
     * @return string
     */
    public function getAdressEmail():string
    {
        return $this->adress_email;
    }

    /**
     * @param string $adress_email
     * @return Avis
     */
    public function setAdressEmail(string $adress_email):self
    {
        $this->adress_email = $adress_email;
        return $this;
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }
    /**
     * @param mixed $id
     * @return Avis
     */
    public function setId($id):self
    {
        $this->id = (int)$id;
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
     * @param mixed $identifianit_id
     * @return Avis
     */
    public function setIdentifiantId($identifianit_id):self
    {
        $this->identifiant_id =(int) $identifianit_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommentaire():string
    {
        return $this->commentaire;
    }

    /**
     * @param string $commentaire
     * @return Avis
     */
    public function setCommentaire(string $commentaire):self
    {
        $this->commentaire = $commentaire;
        return $this;
    }

    /**
     * @return int
     */
    public function getNote():int
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     * @return Avis
     */
    public function setNote($note):self
    {
        $this->note = (int) $note;
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
     * @param mixed $nom
     * @return Avis
     */
    public function setNom($nom):self
    {
        $this->nom = $nom;
        return $this;
    }
}
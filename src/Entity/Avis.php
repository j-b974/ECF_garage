<?php

namespace App\Entity;

class Avis
{
    protected $identifianit_id;
    protected $commentaire;

    protected $note;
    protected $nom;

    /**
     * @return int
     */
    public function getIdentifianitId():int
    {
        return $this->identifianit_id;
    }

    /**
     * @param mixed $identifianit_id
     * @return Avis
     */
    public function setIdentifianitId($identifianit_id):self
    {
        $this->identifianit_id =(int) $identifianit_id;
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
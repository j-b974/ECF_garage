<?php

namespace App\Entity;

class Users
{
    protected $indentifiant_id;

    protected $role;

    protected $password;
    protected $adress_email;
    protected $nom;

    /**
     * @return int
     */
    public function getIndentifiantId():int
    {
        return $this->indentifiant_id;
    }

    /**
     * @param mixed $indentifiant_id
     * @return Users
     */
    public function setIndentifiantId($indentifiant_id):self
    {
        $this->indentifiant_id =(int) $indentifiant_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getRole():string
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     * @return Users
     */
    public function setRole($role):self
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword():string
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return Users
     */
    public function setPassword(string $password):self
    {
        $this->password = $password;
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
     * @return Users
     */
    public function setAdressEmail(string $adress_email):self
    {
        $this->adress_email = $adress_email;
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
     * @return Users
     */
    public function setNom(string $nom):self
    {
        $this->nom = $nom;
        return $this;
    }

}
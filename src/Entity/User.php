<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    protected $identifiant_id;

    protected $role = '';

    protected $password ='';

    protected $nom;

    protected $adress_email;

    protected $prenom;

    /**
     * @return string
     */
    public function getAdressEmail():string
    {
        return $this->adress_email;
    }

    /**
     * @param string $adress_email
     * @return User
     */
    public function setAdressEmail(string $adress_email):self
    {
        $this->adress_email = $adress_email;
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
     * @return User
     */
    public function setIdentifiantId($identifiant_id):self
    {
        $this->identifiant_id = (int) $identifiant_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRole():string
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return User
     */
    public function setRole(string $role):self
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword():string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
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
     * @return User
     */
    public function setNom($nom):self
    {
        $this->nom = $nom;
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
     * @param ?string $prenom
     * @return User
     */
    public function setPrenom(?string $prenom):self
    {
        if($prenom){$this->prenom = $prenom;};
        return $this;
    }

    public function getRoles(): array
    {
        $role = ['ROLE_CLIENT'];
        if($this->role !== 'Administrateur'){
            $role[]='ROLE_EMPLOYER';
        }else{
            $role[]= 'ROLE_DIRECTEUR';
        }

        return array_unique($role);
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->adress_email;
    }

}
<?php

namespace App\Entity;

class UsedCar
{
    protected $id ;
    protected $prix;
    protected $annee_fabrication;
    protected $kilometrage;

    protected $Option;

    protected $caracteristique;
    protected $lstImage = [];

    /**
     * @return mixed
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return UsedCar
     */
    public function setId($id):self
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrix():int
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     * @return UsedCar
     */
    public function setPrix($prix):self
    {
        $this->prix = (int) $prix;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getAnneeFabrication():\DateTime
    {
        return new \DateTime($this->annee_fabrication);
    }

    /**
     * @param mixed $annee_fabrication
     * @return UsedCar
     */
    public function setAnneeFabrication($annee_fabrication):self
    {
        $this->annee_fabrication = $annee_fabrication;
        return $this;
    }

    /**
     * @return int
     */
    public function getKilometrage():int
    {
        return $this->kilometrage;
    }

    /**
     * @param mixed $kilometrage
     * @return UsedCar
     */
    public function setKilometrage($kilometrage):self
    {
        $this->kilometrage = (int) $kilometrage;
        return $this;
    }



}
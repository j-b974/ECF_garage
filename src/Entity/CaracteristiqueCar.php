<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
class CaracteristiqueCar
{
    private $voiture_occassion_id;
    #[Assert\Choice(['essence','diesel','electrique'])]
    public $carburant;
    #[Assert\Choice(['manuel','semi-auto','automatique'])]
    public $boite_vitesse;
    #[Assert\Choice([5,2,3])]
    public $nombre_porte;

    /**
     * @return mixed
     */
    public function getNombrePorte()
    {
        return $this->nombre_porte;
    }

    /**
     * @param mixed $nombre_porte
     * @return CaracteristiqueCar
     */
    public function setNombrePorte($nombre_porte)
    {
        $this->nombre_porte = $nombre_porte;
        return $this;
    }

    /**
     * @return integer
     */
    public function getVoitureOccassionId()
    {
        return (int) $this->voiture_occassion_id;
    }

    /**
     * @param mixed $voiture_occassion_id
     * @return CaracteristiqueCar
     */
    public function setVoitureOccassionId($voiture_occassion_id)
    {
        $this->voiture_occassion_id = $voiture_occassion_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCarburant()
    {
        return $this->carburant;
    }

    /**
     * @param mixed $carburant
     * @return CaracteristiqueCar
     */
    public function setCarburant($carburant)
    {
        $this->carburant = $carburant;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBoiteVitesse()
    {
        return $this->boite_vitesse;
    }

    /**
     * @param mixed $boite_vitesse
     * @return CaracteristiqueCar
     */
    public function setBoiteVitesse($boite_vitess)
    {
        $this->boite_vitesse = $boite_vitess;
        return $this;
    }

}
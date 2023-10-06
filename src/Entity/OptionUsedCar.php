<?php

namespace App\Entity;

class OptionUsedCar
{
    private $voiture_occassion_id;
    public $gps;
    public $radar_recule;
    public $climatisation;

    /**
     * @return mixed
     */
    public function getVoitureOccassionId()
    {
        return (int) $this->voiture_occassion_id;
    }

    /**
     * @param mixed $voiture_occassion_id
     * @return OptionUsedCar
     */
    public function setVoitureOccassionId($voiture_occassion_id)
    {
        $this->voiture_occassion_id = $voiture_occassion_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGps()
    {
        return(bool) $this->gps;
    }

    /**
     * @param mixed $gps
     * @return OptionUsedCar
     */
    public function setGps($gps)
    {
        $this->gps = $gps;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRadarRecule()
    {
        return (bool) $this->radar_recule;
    }

    /**
     * @param mixed $radar_recule
     * @return OptionUsedCar
     */
    public function setRadarRecule($radar_recule)
    {
        $this->radar_recule = $radar_recule;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClimatisation()
    {
        return (bool) $this->climatisation;
    }

    /**
     * @param mixed $climatisation
     * @return OptionUsedCar
     */
    public function setClimatisation($climatisation)
    {
        $this->climatisation = $climatisation;
        return $this;
    }
    public function __toString(): string
    {
        return '';
    }


}
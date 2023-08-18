<?php

namespace App\Repository;
use App\Entity\OptionUsedCar;
use \PDO;
class TableOptionCar
{
    private $bdd ;

    /**
     * @param $bdd
     */
    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }

    public function addOptionCar(OptionUsedCar $option)
    {
        $query = "INSERT INTO option_voiture 
                (voiture_occassion_id, gps, radar_recule, climatisation)
                VALUES(:id, :gps , :radar , :clim)";

        $req = $this->bdd->prepare($query);

        $req->bindValue('id',$option->getVoitureOccassionId(),PDO::PARAM_INT);
        $req->bindValue('gps',$option->getGps(),PDO::PARAM_BOOL);
        $req->bindValue('radar',$option->getRadarRecule(),PDO::PARAM_BOOL);
        $req->bindValue('clim',$option->getClimatisation(),PDO::PARAM_BOOL);
        $req->execute();

        if(!$req){ throw new \Exception("insertion option voiture non réussit !!!!");}

    }

}
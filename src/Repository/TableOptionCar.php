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
    public function getOptionById(int $id):bool|OptionUsedCar
    {
        $query = "SELECT * FROM option_voiture WHERE voiture_occassion_id = :id";

        $req = $this->bdd->prepare($query);
        $req->bindValue('id',$id ,PDO::PARAM_INT);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, OptionUsedCar::class);

        return  $req->fetch() ;
    }
    public function updateOptionCar(OptionUsedCar $option)
    {
        $query ="UPDATE option_voiture 
                 SET  gps= :gps , radar_recule= :radar ,climatisation= :clim
                WHERE voiture_occassion_id = :id";
        $req = $this->bdd->prepare($query);

        $req->bindValue('id',$option->getVoitureOccassionId(),PDO::PARAM_INT);
        $req->bindValue('gps',$option->getGps(),PDO::PARAM_BOOL);
        $req->bindValue('radar',$option->getRadarRecule(),PDO::PARAM_BOOL);
        $req->bindValue('clim',$option->getClimatisation(),PDO::PARAM_BOOL);
         return $req->execute();
    }
    public function isOptionExite(OptionUsedCar $option):bool
    {
        $query="SELECT count(*) FROM option_voiture WHERE voiture_occassion_id = :id";
        $req = $this->bdd->prepare($query);
        $req->bindValue('id',$option->getVoitureOccassionId(),PDO::PARAM_INT);
        $req->execute();
        return (bool) $req->fetchColumn();

    }

}
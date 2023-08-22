<?php

namespace App\Repository;

use App\Entity\CaracteristiqueCar;

use App\Entity\OptionUsedCar;
use \PDO;
class TableCarateristiqueCar
{
    private $bdd ;

    /**
     * @param $bdd
     */
    public function __construct(\PDO $bdd)
    {
        $this->bdd = $bdd;

    }
    public function addCarateristique(CaracteristiqueCar $carat)
    {

        $req = $this->bdd->prepare("INSERT INTO caracteristique_voiture 
        (voiture_occassion_id , carburant ,nombre_porte, boite_vitesse)
        VALUES (:id ,:carbu,:nbporte,:vitesse)");
        $req->bindValue('id',$carat->getVoitureOccassionId(),PDO::PARAM_INT);
        $req->bindValue('carbu',$carat->getCarburant(),PDO::PARAM_STR);
        $req->bindValue('nbporte',$carat->getNombrePorte(),PDO::PARAM_INT);
        $req->bindValue('vitesse',$carat->getBoiteVitesse(),PDO::PARAM_STR);
        $req->execute();
        if(!$req){throw new \Exception("insertion caraterisque non fait !!!!");}

    }
    public function getCaracteristiqueCarById(int $id):bool|CaracteristiqueCar
    {
        $query ="SELECT * FROM caracteristique_voiture WHERE voiture_occassion_id = :id";
        $req = $this->bdd->prepare($query);
        $req->bindValue('id',$id,PDO::PARAM_INT);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, CaracteristiqueCar::class);

        return $req->fetch();
    }
    public function UpdateCarateristique( CaracteristiqueCar $carat)
    {
        $query ="UPDATE caracteristique_voiture 
                 SET carburant= :carbu, nombre_porte= :nbporte, boite_vitesse= :vitesse
                 WHERE voiture_occassion_id = :id";
        $req = $this->bdd->prepare($query);
        $req->bindValue('id',$carat->getVoitureOccassionId(),PDO::PARAM_INT);
        $req->bindValue('carbu',$carat->getCarburant(),PDO::PARAM_STR);
        $req->bindValue('nbporte',$carat->getNombrePorte(),PDO::PARAM_INT);
        $req->bindValue('vitesse',$carat->getBoiteVitesse(),PDO::PARAM_STR);
        return $req->execute();

    }
    public function isCarateristiqueExite(CaracteristiqueCar $carat):bool
    {
        $query="SELECT count(*) FROM caracteristique_voiture WHERE voiture_occassion_id = :id";
        $req = $this->bdd->prepare($query);
        $req->bindValue('id',$carat->getVoitureOccassionId(),PDO::PARAM_INT);
        $req->execute();
        return (bool) $req->fetchColumn();

    }

}
<?php

namespace App\Repository;

use App\Entity\CaracteristiqueCar;

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
}
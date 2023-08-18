<?php

namespace App\Repository;
use App\Entity\UsedCar;
use App\Repository\{TableOptionCar,TableCarateristiqueCar};
use \PDO;
class TableUsedCar
{
    private $bdd;
    private $ToptionCar;
    private $TcaraterisqueCar;
    /**
     * @param $bdd
     */
    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
        $this->TcaraterisqueCar = new TableCarateristiqueCar($this->bdd);
        $this->ToptionCar = new TableOptionCar($this->bdd);
    }
    public function getAllUserCar()
    {
        $req = $this->bdd->query("SELECT * FROM voiture_occassion");
        $req->setFetchMode(PDO::FETCH_CLASS, UsedCar::class);
        return $req->fetchAll();
    }
    public function addUserCar(UsedCar $car)
    {
        $req = $this->bdd->prepare("INSERT INTO voiture_occassion (prix , annee_fabrication ,kilometrage) VALUES (:prix , :dataFab , :kilo)");
        $req->bindValue('prix',$car->getPrix(),PDO::PARAM_INT);
        $req->bindValue('dataFab', $car->getAnneeFabrication()->format('Y-m-d'));
        $req->bindValue('kilo',$car->getKilometrage(),PDO::PARAM_INT);
        $req->execute();

        if(!$req){throw new \Exception("insertion voiture n'a pas réussit !!!");}

        $id =(int) $this->bdd->lastInsertId();
        if($car->getCaracteristique() !== null){
            $carat = $car->getCaracteristique();
            $carat->setVoitureOccassionId($id);

            $this->TcaraterisqueCar->addCarateristique($carat);
        }
        if($car->getOption() !== null)
        {
            $opt = $car->getOption()->setVoitureOccassionId($id);
            $this->ToptionCar->addOptionCar($opt);
        }
    }

}
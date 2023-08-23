<?php

namespace App\Repository;
use App\Entity\UsedCar;
use App\Repository\{TableOptionCar,TableCarateristiqueCar,TableImageCar};
use \PDO;
class TableUsedCar
{
    private $bdd;
    private $ToptionCar;
    private $TcaraterisqueCar;
    private $TimageCar;
    /**
     * @param $bdd
     */
    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
        $this->TcaraterisqueCar = new TableCarateristiqueCar($this->bdd);
        $this->ToptionCar = new TableOptionCar($this->bdd);
        $this->TimageCar = new TableImageCar($this->bdd);
    }
    public function getAllUserCar()
    {
        $req = $this->bdd->query("SELECT * FROM voiture_occassion");
        $req->setFetchMode(PDO::FETCH_CLASS, UsedCar::class);
        $lstUsedCar= $req->fetchAll();
        foreach ($lstUsedCar as $usedCar)
        {
            $usedCar->setLstImage($this->hydrateLstImgUsedCar($usedCar->getId()));
        }
        return $lstUsedCar;
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
        $car->setId($id);
        $this->hydrateEtityFollow($car);
    }

    public function updateUseCar(UsedCar $car)
    {
        $query ="UPDATE voiture_occassion 
                 SET prix= :prix ,annee_fabrication= :dataFab , kilometrage =:kilo
                 WHERE id = :id";
        $req = $this->bdd->prepare($query);
        $req->bindValue('id',$car->getId(),PDO::PARAM_INT);
        $req->bindValue('prix',$car->getPrix(),PDO::PARAM_INT);
        $req->bindValue('dataFab', $car->getAnneeFabrication()->format('Y-m-d'));
        $req->bindValue('kilo',$car->getKilometrage(),PDO::PARAM_INT);
        $req->execute();
        if(!$req){throw new \Exception('update voiture occassion non réussit !!!');}
        $this->hydrateEtityFollowUpdate($car);

    }
    public function getUsedCarById(int $id):UsedCar
    {
        $query ="SELECT voiture_occassion.* 
                 FROM voiture_occassion 
                 WHERE voiture_occassion.id = :id";
        $req = $this->bdd->prepare($query);

        $req->bindValue('id',$id,PDO::PARAM_INT);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS , UsedCar::class);
        $usedCar = $req->fetch();

        /**
         * @var $usedCar UsedCar
         */
        $usedCar->setOption( $this->ToptionCar->getOptionById($usedCar->getId()));
        $usedCar->setCaracteristique($this->TcaraterisqueCar->getCaracteristiqueCarById($usedCar->getId()));
        $usedCar->setLstImage($this->hydrateLstImgUsedCar($usedCar->getId()));
        return $usedCar;

    }
    public function hydrateLstImgUsedCar(int $id):array
{
    return $this->TimageCar->getLstImageCarById($id);

}

    public function hydrateEtityFollow(UsedCar $car)
    {
        if($car->getCaracteristique() !== null){
            $carat = $car->getCaracteristique();
            $carat->setVoitureOccassionId($car->getId());

            $this->TcaraterisqueCar->addCarateristique($carat);
        }
        if($car->getOption() !== null)
        {
            $opt = $car->getOption()->setVoitureOccassionId($car->getId());
            $this->ToptionCar->addOptionCar($opt);
        }
        if(!empty($car->getLstImage()))
        {
            foreach($car->getLstImage() as $imgCar)
            {
                $imgCar->setVoitureOccassionId($car->getId());
                $this->TimageCar->addImageCar($imgCar);
            }
        }
    }
    public function hydrateEtityFollowUpdate(UsedCar $car)
    {
        // ===== pour pas que les valeur null donne des erreurs ==========

        if($car->getCaracteristique() !== null){
            $carat = $car->getCaracteristique();
            $carat->setVoitureOccassionId($car->getId());

            // si pas de caraterisque on n'en cree sinon uptdate
            if($this->TcaraterisqueCar->isCarateristiqueExite($carat)){
                $this->TcaraterisqueCar->UpdateCarateristique($carat);
            }else{
                $this->TcaraterisqueCar->addCarateristique($carat);
            }
        }

        if($car->getOption() !== null)
        {
            $opt = $car->getOption()->setVoitureOccassionId($car->getId());

            if($this->ToptionCar->isOptionExite($opt)){
                $this->ToptionCar->updateOptionCar($opt);
            }else{
                $this->ToptionCar->addOptionCar($opt);
            }
        }
        if(!empty($car->getLstImage()))
        {
            foreach($car->getLstImage() as $imgCar)
            {
                // évite de doublé a chaque update
                if($imgCar->getId() == null ){
                    $imgCar->setVoitureOccassionId($car->getId());
                    $this->TimageCar->addImageCar($imgCar);
                }
            }
        }
    }
    public function deleteUsedCar(UsedCar $usedCar)
    {
        $query ="DELETE FROM voiture_occassion
                 WHERE id = :id LIMIT 1";
        $req =$this->bdd->prepare($query);
        $req->bindValue('id',$usedCar->getId(),PDO::PARAM_INT);
        $req->execute();
    }

}
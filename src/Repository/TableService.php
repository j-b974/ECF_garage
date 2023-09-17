<?php

namespace App\Repository;
use App\Entity\Service;
use \PDO;
class TableService
{
    private $bdd;

    public function __construct( PDO $bdd)
    {
        $this->bdd = $bdd;
    }

    public function getAllTitreService()
    {
        $query ="SELECT * FROM titre_service";
        $req = $this->bdd->prepare($query);
        $req->execute();
        return  $req->fetchAll(PDO::FETCH_COLUMN);
    }
    public function addTitreService(string $name)
    {
        $query="INSERT INTO titre_service(titre) VALUES(:nameSer)";
        $req = $this->bdd->prepare($query);
        $req->bindValue('nameSer' , $name , PDO::PARAM_STR);
        $req->execute();
    }
    public function updateTitreService(string $Newname, string $oldName)
    {
        $query ="UPDATE titre_service SET titre = :nameSer WHERE titre = :oldname";
        $req = $this->bdd->prepare($query);
        $req->bindValue('nameSer', $Newname,PDO::PARAM_STR);
        $req->bindValue('oldname', $oldName,PDO::PARAM_STR);
        $req->execute();
    }
    public function deleteTitreService(string $name)
    {
        $query ="DELETE FROM titre_service WHERE titre = :nameSer LIMIT 1";
        $req = $this->bdd->prepare($query);
        $req->bindValue('nameSer',$name , PDO::PARAM_STR);
        $req->execute();
    }

    public function addService(Service $service)
    {
        $query = "INSERT INTO service_garage (titre , nom_service , label_Prix ) VALUES (:titre , :nameSer , :lable)";
        $req = $this->bdd->prepare($query);
        $req->bindValue('titre',$service->getTitre() , PDO::PARAM_STR);
        $req->bindValue('nameSer',$service->getNomService() , PDO::PARAM_STR);
        $req->bindValue('lable',$service->getLabelPrix() , PDO::PARAM_STR);
        $req->execute();

        $service->setId($this->bdd->lastInsertId());

    }
    public function updateService(Service $service)
    {
        $query ="UPDATE service_garage SET titre = :titre , nom_service = :nom , label_Prix = :label 
                      WHERE id = :id LIMIT 1";
        $req = $this->bdd->prepare($query);
        $req->bindValue('titre',$service->getTitre() , PDO::PARAM_STR);
        $req->bindValue('nom',$service->getNomService() , PDO::PARAM_STR);
        $req->bindValue('label',$service->getLabelPrix() , PDO::PARAM_STR);
        $req->bindValue('id',$service->getId() , PDO::PARAM_INT);
        $req->execute();
    }
    public function deleteService(Service $service )
    {
        $this->bdd->exec( "DELETE FROM service_garage WHERE id ={$service->getId()} ");
    }
    public function getAllServiceByTitre(string $titreServie)
    {
        $query = "SELECT * FROM service_garage WHERE titre = :titre";
        $req = $this->bdd->prepare($query);
        $req->bindValue('titre',$titreServie ,PDO::PARAM_STR);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS , Service::class);
        return $req->fetchAll();
    }
    public function getAllService()
    {
        $query = "SELECT * FROM service_garage";
        $req = $this->bdd->prepare($query);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS , Service::class);
        return $req->fetchAll();
    }
    public function isTitreExite(string $titre)
    {
        $query = "SELECT count(titre) FROM titre_service WHERE titre = :titre ";
        $req = $this->bdd->prepare($query);
        $req->bindValue('titre',$titre,PDO::PARAM_STR);
        $req->execute();
        return (bool) $req->fetchColumn();
    }
    public function getServiceById(int $id)
    {
        $query = "SELECT * FROM service_garage WHERE titre = :id";
        $req = $this->bdd->prepare($query);
        $req->bindValue('id',$id ,PDO::PARAM_INT);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS , Service::class);
        return $req->fetch();
    }
    public function deleteServiceNotList(array $lstService)
    {
         $titre= $lstService[0]->getTitre();
        $lstId = array_map(function($service){
            return $service->getId();
        },$lstService);
      $fmListId = implode(" ' , ' ",$lstId);

        $querry ="DELETE FROM service_garage WHERE titre= :tit AND id NOT IN ( ' $fmListId ' ) " ;
        $req = $this->bdd->prepare($querry);
        $req->bindValue('tit', $titre , PDO::PARAM_STR);
        //$req->bindValue('lstId',$fmListId, PDO::PARAM_STR);
        $req->execute();
    }
}
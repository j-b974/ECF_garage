<?php

namespace App\Repository;
use App\Entity\ImageCar;
use \PDO;
class TableImageCar
{
    private $bdd;

    /**
     * @param $bdd
     */
    public function __construct(\PDO $bdd)
    {
        $this->bdd = $bdd;
    }

    public function addImageCar(ImageCar $imgCar)
    {
        if($imgCar->getPathImage() == 'defaultCar.jpg'){return;}

        $query = "INSERT INTO image_voiture (voiture_occassion_id, path_image) VALUES(:idCar, :pathCar )";
        $req = $this->bdd->prepare( $query );
        $req->bindValue('idCar',$imgCar->getVoitureOccassionId(),PDO::PARAM_INT);
        $req->bindValue('pathCar',$imgCar->getPathImage(),PDO::PARAM_STR);

        $req->execute();
        if(!$req){throw new \Exception("ajoute image non réussit !!!");}

    }

    public function getLstImageCarById(int $id):array
    {
        $query ="SELECT * FROM image_voiture WHERE voiture_occassion_id = :id";
        $req = $this->bdd->prepare($query);

        $req->bindValue('id',$id,PDO::PARAM_INT);
        $req->execute();

        if(!$req){throw new \Exception('erreur des récupération img !!!');}

        $req->setFetchMode(PDO::FETCH_CLASS, ImageCar::class);
        return $req->fetchAll();

    }
    public function getImageById(int $id):ImageCar
    {
        $query ="SELECT * FROM image_voiture
                 WHERE id = :id";
        $req = $this->bdd->prepare($query);
        $req->bindValue('id',$id,PDO::PARAM_INT);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS, ImageCar::class);
        return $req->fetch();
    }
    public function deleteImageById(int $id)
    {
        $query ="DELETE FROM image_voiture
                 WHERE id = :id LIMIT 1";
        $req = $this->bdd->prepare($query);
        $req->bindValue('id',$id,PDO::PARAM_INT);
        $req->execute();
    }



}
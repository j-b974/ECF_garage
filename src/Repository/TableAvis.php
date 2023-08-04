<?php

namespace App\Repository;

use App\Entity\Avis;

class TableAvis
{
    private $bdd ;
    private $Tidentifiant;

    public function __construct(\PDO $bdd)
    {
        $this->bdd = $bdd;
        $this->Tidentifiant = new TableIdentifiant($this->bdd);
    }

    /**
     * @return Avis[]
     * @descript return une liste d'objet Avis
     */
    public function getAllAvis():array
    {
        $req  = $this->bdd->query("SELECT avis.* , identifiant.nom ,identifiant.adress_email FROM avis 
                                    LEFT JOIN  identifiant ON avis.identifiant_id = identifiant.id");
        $req-> setFetchMode(\PDO::FETCH_CLASS , Avis::class);
        $rep = $req->fetchAll();
        return $rep ;
    }
    /**
     * @param Avis $avis
     * @return void
     * @throws \Exception
     * @descript hydrate identifiant_id de l'objet Avis ;
     */
    public function addAvis(Avis $avis)
    {
        $id = $this->isEmailExite($avis);
        if($id)
        {
            $avis->setIdentifianitId($id);
        }else{
          $id =   $this->Tidentifiant->addIdentifiant($avis->getNom(),$avis->getAdressEmail());
          $avis->setIdentifianitId($id);
        }
        $req = $this->bdd->prepare("INSERT INTO avis SET identifiant_id = :id , commentaire = :com , note = :note");
        $req->bindValue('id',$avis->getIdentifianitId(),\PDO::PARAM_INT);
        $req->bindValue('com',$avis->getCommentaire(),\PDO::PARAM_STR);
        $req->bindValue('note',$avis->getNote(),\PDO::PARAM_INT);
        $req->execute();
        if(!$req){throw new \Exception("insertion avis n'a pas reussit !!!");}

        return $this;
    }
    public function isEmailExite(Avis $avis)
    {

        $id = $this->Tidentifiant->isEmailExite($avis->getAdressEmail());
        return $id;
    }
}
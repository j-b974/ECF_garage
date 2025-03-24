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
        $req  = $this->bdd->query(
            "SELECT avis.* , identifiant.nom ,identifiant.adress_email 
                    FROM avis 
                    LEFT JOIN  identifiant 
                    ON avis.identifiant_id = identifiant.id");
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
        $data = $this->isEmailExite($avis);
        if($data)
        {
            $avis->setIdentifiantId($data['id']);
        }else{
          $id =   $this->Tidentifiant->addIdentifiant($avis->getNom(),$avis->getAdressEmail());
          $avis->setIdentifiantId($id);
        }
        $req = $this->bdd->prepare("INSERT INTO avis SET identifiant_id = :id , commentaire = :com , note = :note , status= :status");
        $req->bindValue('id',$avis->getIdentifiantId(),\PDO::PARAM_INT);
        $req->bindValue('com',$avis->getCommentaire(),\PDO::PARAM_STR);
        $req->bindValue('note',$avis->getNote(),\PDO::PARAM_INT);
        $req->bindValue('status',$avis->getStatus(),\PDO::PARAM_STR);
        $req->execute();
        $avis->setId($this->bdd->lastInsertId());
        if(!$req){throw new \Exception("insertion avis n'a pas reussit !!!");}

        return $this;
    }
    public function isEmailExite(Avis $avis)
    {
        $id = $this->Tidentifiant->isEmailExite($avis->getAdressEmail());
        return $id;
    }
    public function isExiteAvisId(int $id):bool
    {
        $query = "SELECT COUNT(*) FROM avis WHERE avis.id = ?";
        $req = $this->bdd->prepare($query);
        $req->execute([$id]);
        return (bool) $req->fetchColumn();
    }
    public function getAvisById(int $id):Avis
    {

        $req = $this->bdd->query("SELECT avis.id ,avis.identifiant_id, avis.commentaire, avis.note , avis.status ,identifiant.nom , identifiant.adress_email FROM avis 
            LEFT JOIN identifiant ON identifiant_id = identifiant.id
            WHERE avis.id=$id ");
        $req->setFetchMode(\PDO::FETCH_CLASS, Avis::class);
        $avis = $req->fetch();
        return $avis;
    }
    public function updateAvis(Avis $avis):Avis
    {
        $req = $this->bdd->prepare("UPDATE avis SET commentaire= :comm , note= :note , status= :publish WHERE id = :id LIMIT 1");
        $req->bindValue('note',$avis->getNote(),\PDO::PARAM_INT);
        $req->bindValue('comm',$avis->getCommentaire(),\PDO::PARAM_STR);
        $req->bindValue('publish',$avis->getStatus(),\PDO::PARAM_STR);
        $req->bindValue('id',$avis->getId(), \PDO::PARAM_INT);
        $req->execute();
        if(!$req){ throw new \Exception('Update AVis non reussit !!!');
        }
        return $avis;
    }

    /**
     * @param int|Avis $avis id ou Avis
     * @return void
     * @throws
     */
    public function delecte(int|Avis $avis):void
    {
        $id = $avis instanceof Avis ? $avis->getId() : $avis;
        $req = $this->bdd->query("DELETE FROM avis WHERE id = $id LIMIT 1");
        if(!$req){throw new \Exception("la suppréssion ne c'est pas éffectuée !!!");}
    }
    public function getCountNewAvis():int
    {
        $query = "SELECT count(id) FROM avis WHERE status = :newn";
        $req = $this->bdd->prepare($query);
        $req->bindValue('newn','nouveau',\PDO::PARAM_STR);
        $req->execute();
        return $req->fetchColumn();
    }
}
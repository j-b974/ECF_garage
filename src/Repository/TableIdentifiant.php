<?php

namespace App\Repository;
use \PDO;
class TableIdentifiant
{
    private $bdd;
    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }

    /**
     * @param string $nom
     * @param string $email
     * @param string|null $prenom
     * @return int|string Id de l'insertion !
     * @throws \Exception
     * @descript return insert id
     */
    public function addIdentifiant(string $nom , string $email,string $prenom = null){
        $req = $this->bdd->prepare("INSERT INTO identifiant SET nom = :nom , adress_email = :email, prenom = :prenom");
        $req->bindValue('nom',$nom, PDO::PARAM_STR);
        $req->bindValue('email',$email,PDO::PARAM_STR);
        $req->bindValue('prenom',$prenom,PDO::PARAM_STR);
        $req->execute();
        if(!$req){throw new \Exception("insertion identifiant n'a pas reussit !!!");}

        return $this->bdd->lastInsertId();
    }

    /**
     * @descript search id if email exit
     * @param string $email
     * @return false|array
     */
    public function isEmailExite(string $email)
    {
        // bug si n'est pas dans une variable !!!
        $query = "SELECT COUNT(adress_email), id , prenom FROM identifiant WHERE adress_email = :email ";
        $req = $this->bdd->prepare($query);
        $req->bindValue('email',$email,PDO::PARAM_STR);
        $req->execute();
        $rep = $req->fetch(PDO::FETCH_ASSOC);
       return $rep['COUNT(adress_email)'] == '0' ? false : $rep;
    }
}
<?php

namespace App\Repository;
use App\Entity\User;
use \PDO;
class TableUser
{
    private $bdd;
    private $Tidentifiant;

    /**
     * @param $bdd
     */
    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
        $this->Tidentifiant = new TableIdentifiant($this->bdd);
    }
    public function addUser(User $user)
    {
        $data = $this->isUserExite($user);
        if($data){
          return   $this->getUserById($data['id']);
        }else{
            $id = $this->Tidentifiant->addIdentifiant($user->getNom(),$user->getAdressEmail(),$user->getPrenom());
            $query ="INSERT INTO user (identifiant_id ,role ,password) VALUES (:id,:rr,:pass)";
            $req = $this->bdd->prepare($query);
            $req->bindValue('id',$id,PDO::PARAM_INT);
            $req->bindValue('rr',$user->getRole(),PDO::PARAM_STR);
            $req->bindValue('pass',$user->getPassword(),PDO::PARAM_STR);
            $req->execute();
            if(!$req){throw  new \Exception("insertion user n'a pas réussit !!!");}
            $user->setIdentifiantId($id);
            return $user;
        }
    }
    public function isUserExite(User $user)
    {
        return $this->Tidentifiant->isEmailExite($user->getAdressEmail());
    }
    public function getUserById(int $id):bool|User
    {
        $req = $this->bdd->query("SELECT  user.role , user.identifiant_id, user.password, identifiant.nom , identifiant.prenom, identifiant.adress_email FROM user 
            LEFT JOIN identifiant ON user.identifiant_id = identifiant.id 
               WHERE identifiant.id = $id");
        $req->setFetchMode(PDO::FETCH_CLASS, user::class);
        return $req->fetch();
    }

}
<?php

namespace App\Repository;
use App\Entity\User;
use Exception;
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

    /**
     * @throws Exception
     */
    public function addUser(User $user):User
    {
        $data = $this->isUserExite($user);
        if($data){
          return   $this->getUserById($data['id']);
        }else{
            $id = $this->Tidentifiant->addIdentifiant(
                $user->getNom(),$user->getAdressEmail(),
                $user->getPrenom());
            $query ="INSERT INTO user (identifiant_id ,role ,password) 
                     VALUES (:id,:role,:pass)";
            $req = $this->bdd->prepare($query);
            $req->bindValue('id',$id,PDO::PARAM_INT);
            $req->bindValue('role',$user->getRole(),PDO::PARAM_STR);
            $req->bindValue('pass',$user->getPassword(),PDO::PARAM_STR);
            $req->execute();
            $user->setIdentifiantId($id);
            return $user;
        }
    }
    public function isUserExite(User $user)
    {
        return $this->Tidentifiant->isEmailExite($user->getAdressEmail());
    }
    public function isExiteUserById(int $id): bool
    {
        $query= "SELECT COUNT(*) FROM identifiant WHERE identifiant.id = ?";
        $req = $this->bdd->prepare($query);
        $req->execute([$id]);
        return (bool) $req->fetchColumn();
    }
    public function getUserById(int $id):bool|User
    {
        $query = "
            SELECT  user.role , user.identifiant_id, user.password, 
                    identifiant.nom , identifiant.prenom, identifiant.adress_email 
            FROM user 
            LEFT JOIN identifiant ON user.identifiant_id = identifiant.id 
            WHERE user.identifiant_id = :id";
        $req = $this->bdd->prepare($query);
        $req->bindValue('id', $id, PDO::PARAM_INT);
        $req->setFetchMode(PDO::FETCH_CLASS, User::class);
        $req->execute();
        return $req->fetch();
    }
    public function getAllUser():array
    {
        $query ="SELECT user.role , user.password, user.identifiant_id, user.password , identifiant.id , identifiant.nom , identifiant.prenom,
                identifiant.adress_email FROM user 
                LEFT JOIN identifiant ON user.identifiant_id = identifiant.id";
        $req = $this->bdd->prepare($query);
        $req->execute();
        $req->setFetchMode(PDO::FETCH_CLASS , User::class);
        return $req->fetchAll();
    }
    public function updateUser(User $user)
    {
        $this->Tidentifiant->updateIdentifiant( $user->getIdentifiantId() ,$user->getNom() ,$user->getAdressEmail() , $user->getPrenom());

        $query ="UPDATE user SET password = :word WHERE identifiant_id = :id";
        $req = $this->bdd->prepare($query);
        $req->bindValue('word',$user->getPassword(), PDO::PARAM_STR);
        $req->bindValue('id',$user->getIdentifiantId(),PDO::PARAM_INT);
        $req->execute();
    }
    public function deleteUser(User $user)
    {
        $this->Tidentifiant->deleteIdentifiant($user->getIdentifiantId());
    }

}
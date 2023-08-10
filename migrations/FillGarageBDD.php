<?php
use \App\Repository\DataBaseGarage;

require dirname(__DIR__).'/vendor/autoload.php';

$bdd = DataBaseGarage::connection();

// creation de voiture occassion
$Tcar = new \App\Repository\TableUsedCar($bdd);
$faker = Faker\Factory::create('fr_FR');
for($i=0;$i<= 50 ;$i++)
{
    $car = new \App\Entity\UsedCar();
    $car->setPrix($faker->numberBetween(3,22)*1000)
        ->setKilometrage($faker->numberBetween(6 , 18)*10000)
        ->setAnneeFabrication($faker->dateTime()->format('Y-m-d'));
    $Tcar->addUserCar($car);
    $Tcar->getAllUserCar();
}
// creation d'avis
$Tavis = new \App\Repository\TableAvis($bdd);
for($i=0; $i<= 50; $i++)
{
    $avis1 = new \App\Entity\Avis();
    $avis1->setNom($faker->lastName())
        ->setCommentaire($faker->realText(155))
        ->setNote($faker->numberBetween(1,5))
        ->setAdressEmail($faker->email());
    $Tavis->addAvis($avis1);
    $Tavis->getAllAvis();
}
// creation de contact
$Tcontact = new \App\Repository\TableContact($bdd);
for($i=0;$i<=50;$i++)
{
    $contact = new \App\Entity\contact();
    $contact->setNom($faker->lastName())
        ->setPrenom($faker->firstName())
        ->setAdressEmail($faker->email())
        ->setMessage($faker->realText(155))
        ->setNumeroTelephone($faker->phoneNumber());
    $Tcontact->addContact($contact);
    $rep = $Tcontact->getAllContact();
}
// creation utilisateur
$Tuser = new \App\Repository\TableUser($bdd);
for($i=0;$i<=50 ; $i++)
{
    $user = new \App\Entity\User();
    $user->setNom($faker->lastName())
        ->setPrenom($faker->firstName())
        ->setAdressEmail($faker->email())
        ->setPassword($faker->password())
        ->setRole('Employ');
    $Tuser->addUser($user);
}

//$req = $bdd->query("INSERT INTO identifiant (nom , prenom,adress_email) values ('jean','bruno','test@hotmaik.gg')");
//$req->fetch();

echo 'la BDD a correctement était remplie !!!!';
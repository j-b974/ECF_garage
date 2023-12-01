<?php


use App\Entity\Service;
use App\Repository\DataBaseGarage;

require dirname(__DIR__).'/vendor/autoload.php';

$bdd = DataBaseGarage::connection();

echo 'debut du remplissage !!!';
// creation de voiture occassion
$Tcar = new \App\Repository\TableUsedCar($bdd);
$faker = Faker\Factory::create('fr_FR');

for($i=0;$i<= 50 ;$i++)
{
    $car = new \App\Entity\UsedCar();
    $car->setPrix($faker->numberBetween(3,22)*1000)
        ->setKilometrage($faker->numberBetween(6 , 18)*10000)
        ->setAnneeFabrication($faker->dateTime()->format('Y-m-d'));

    // initialise les caracteeristique
    $carCaracte = new \App\Entity\CaracteristiqueCar();
    $carCaracte->setCarburant($faker->randomElement(['essence','diesel','electrique']))
        ->setBoiteVitesse($faker->randomElement(['manuel','semi-auto','automatique']))
        ->setNombrePorte($faker->randomElement([2,3,5]));
    $car->setCaracteristique($carCaracte);

    // iniitalise les Option
    $carOption = new \App\Entity\OptionUsedCar();
    $carOption->setClimatisation($faker->randomElement([true , false]))
        ->setGps($faker->randomElement([true , false]))
        ->setRadarRecule($faker->randomElement([true , false]));
    $car->setOption($carOption);

    $Tcar->addUserCar($car);
    $Tcar->getAllUserCar();
}
// creation d'avis
$Tavis = new \App\Repository\TableAvis($bdd);

// nombre de nouveau Avis à créé
$newMessage = 3;

for($i=0; $i<= 50; $i++)
{
    $avis1 = new \App\Entity\Avis();
    $avis1->setNom($faker->lastName())
        ->setCommentaire($faker->realText(155))
        ->setNote($faker->numberBetween(1,5))
        ->setStatus($faker->randomElement(['modifier','verifier']))
        ->setAdressEmail($faker->email());
    if($newMessage > 0){
        $avis1->setStatus('nouveau');
    }
    $Tavis->addAvis($avis1);
    $Tavis->getAllAvis();
    $newMessage--;
}
// creation de contact
$Tcontact = new \App\Repository\TableContact($bdd);

// nombre de nouveau contact
$newMessage = 5;
for($i=0;$i<=50;$i++)
{
    $contact = new \App\Entity\contact();
    $contact->setNom($faker->lastName())
        ->setPrenom($faker->firstName())
        ->setAdressEmail($faker->email())
        ->setEtat($faker->randomElement(['lu','traitement']))
        ->setMessage($faker->realText(155))
        ->setNumeroTelephone($faker->phoneNumber());
    if($newMessage > 0){
        $contact->setEtat('nouveau');
    }
    $Tcontact->addContact($contact);
    $rep = $Tcontact->getAllContact();
    $newMessage--;
}
// creation de service de garage

for($i=0;$i<= 5 ; $i++)
{
    $Tservice = new \App\Repository\TableService($bdd);
    $titre = $faker->word();
    $Tservice->addTitreService($titre);
    $nbServ = $faker->numberBetween(3 , 5);
    for($ser= 0 ; $ser <= $nbServ ; $ser++)
    {
        $service = new Service();
        $service->setTitre($titre)
            ->setNomService($faker->word())
            ->setLabelPrix($faker->numberBetween(15 , 45 ).'€/heure');
        $Tservice->addService($service);
    }
}

// creation utilisateur

echo PHP_EOL.'le hash des passWord va prend quelque instant  !!!';
$Tuser = new \App\Repository\TableUser($bdd);
$admin = new \App\Entity\User();
$admin->setNom('super')
    ->setPrenom('power')
    ->setAdressEmail('admin@admin.com')
    ->setRole('Administrateur')
    ->setPassword(\App\Services\HasherGarage::hashUser()->hashPassword(
        $admin,
        'admin'
    ));
$Tuser->addUser($admin);
for($i=0;$i<=50 ; $i++)
{
    $user = new \App\Entity\User();
    $user->setNom($faker->lastName())
        ->setPrenom($faker->firstName())
        ->setAdressEmail($faker->email())
        ->setPassword(\App\Services\HasherGarage::hashUser()->hashPassword(
            $user,
            '1234'
        ))
        ->setRole('Employ');
    $Tuser->addUser($user);
}

//$req = $bdd->query("INSERT INTO identifiant (nom , prenom,adress_email) values ('jean','bruno','test@hotmaik.gg')");
//$req->fetch();

echo PHP_EOL.'la BDD a correctement était remplie !!!!';
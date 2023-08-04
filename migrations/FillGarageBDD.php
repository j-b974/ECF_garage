<?php
use \App\Repository\DataBaseGarage;

require dirname(__DIR__).'/vendor/autoload.php';

$bdd = DataBaseGarage::connection();
$Tavis = new \App\Repository\TableAvis($bdd);
$avis1 = new \App\Entity\Avis();
$avis1->setNom('bonjour')
    ->setCommentaire('une long commentaire teste testtt')
    ->setNote(5)
    ->setAdressEmail('dfehr@ok');
$Tavis->addAvis($avis1);
$rep = $Tavis->getAllAvis();

print_r($rep);

//$req = $bdd->query("INSERT INTO identifiant (nom , prenom,adress_email) values ('jean','bruno','test@hotmaik.gg')");
//$req->fetch();



echo 'reussit !!!!';
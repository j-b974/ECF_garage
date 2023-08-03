<?php
use \App\Repository\DataBaseGarage;
require dirname(__DIR__).'/vendor/autoload.php';

$bdd = DataBaseGarage::connection();




$req = $bdd->query("INSERT INTO identifiant (nom , prenom,adress_email) values ('jean','bruno','test@hotmaik.gg')");
$req->fetch();

echo 'reussit !!!!';
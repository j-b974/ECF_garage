<?php
use \App\Repository\DataBaseGarage;

require dirname(__DIR__).'/vendor/autoload.php';

$bdd = DataBaseGarage::connection();
$Tavis = new \App\Repository\TableAvis($bdd);
$Tcontact = new \App\Repository\TableContact($bdd);
$Tuser = new \App\Repository\TableUser($bdd);
$Tcar = new \App\Repository\TableUsedCar($bdd);
$avis1 = new \App\Entity\Avis();

$car = new \App\Entity\UsedCar();
$car->setPrix(25500)
    ->setKilometrage(33000)
    ->setAnneeFabrication("21-07-2012");
$Tcar->addUserCar($car);
$req = $Tcar->getAllUserCar();
var_dump($req);

/**$avis1->setNom('bobibi')
    ->setCommentaire('jlkjmkjune long commentaijkljkjre teste testtt')
    ->setNote(3)
    ->setAdressEmail('dfe-thbv-r@ok');
$Tavis->addAvis($avis1);
$rep = $Tavis->getAllAvis();
*/
/**$user = new \App\Entity\User();
$user->setNom('bebe55')
    ->setPrenom('dododo55')
    ->setAdressEmail('dfkjkljklmkdfdfe.hug')
    ->setPassword('123456789')
    ->setRole('Employ');
$Tuser->addUser($user);
*/

/**$contact = new \App\Entity\contact();
$contact->setNom('lolo')
    ->setPrenom('pierre')
    ->setAdressEmail('aaa@bbb.ff')
    ->setMessage('je suis ok ')
    ->setNumeroTelephone(123456789);
$Tcontact->addContact($contact);
$rep = $Tcontact->getAllContact();
 */


//$req = $bdd->query("INSERT INTO identifiant (nom , prenom,adress_email) values ('jean','bruno','test@hotmaik.gg')");
//$req->fetch();



echo 'reussit !!!!';
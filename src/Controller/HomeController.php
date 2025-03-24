<?php
namespace App\Controller;

use App\Repository\DataBaseGarage;
use App\Repository\TableAvis;

use App\Repository\TableUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route('/','home',methods: ['GET'])]
    public function home():Response
    {
        $bdd = DataBaseGarage::connection();
        $Tavis = new TableAvis($bdd);
        $lstAvis = $Tavis->getAllAvis();

        $lstAvis = array_filter($lstAvis, function ($avis){
            return $avis->getStatus() != "nouveau";
        });

        $rand = array_rand($lstAvis , 3);
        $Tuser = new TableUser($bdd);

        $lst=[];
        foreach ($rand as $value){
                $lst[] = $lstAvis[$value];
        }

        return $this->render('/Pages/home.html.twig', [
            'lstAvis'=>$lst,
            'image_fond'=> 'acceuilGarage2.jpg'
        ]);
    }

}
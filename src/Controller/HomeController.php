<?php
namespace App\Controller;

use App\Repository\DataBaseGarage;
use App\Repository\TableAvis;
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

        return $this->render('/Pages/home.html.twig',
        [ 'lstAvis'=>$lstAvis]);
    }

}
<?php

namespace App\Controller;

use App\Repository\DataBaseGarage;
use App\Repository\TableAvis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAvisController extends AbstractController
{
    #[Route('/admin/avis', name: 'admin_avis',methods: ['GET','POST'])]
    public function index(): Response
    {
        $bdd = DataBaseGarage::connection();
        $Tavis = new TableAvis($bdd);
        $lstAvis = $Tavis->getAllAvis();
        return $this->render('Pages/administration/AvisAdmin.html.twig', [
            'controller_name' => 'AdminAvisController',
            'lstAvis'=>$lstAvis
        ]);
    }
    #[Route('/admin/avis/Creation', name:'create_avis', methods: ['GET','POST'])]
    public function new():Response
    {
        return $this->render('Pages/administration/CreatAvis.html.twig',[

        ]);
    }

}

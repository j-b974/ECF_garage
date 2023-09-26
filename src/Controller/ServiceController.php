<?php

namespace App\Controller;

use App\Repository\DataBaseGarage;
use App\Repository\TableService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'service',methods: ['GET'])]
    public function index(): Response
    {

        $Tservice = new TableService(DataBaseGarage::connection());

        $lstTitre = [];
        foreach( $Tservice->getAllTitreService() as $lstService)
        {
            $lstTitre[$lstService] = $Tservice->getAllServiceByTitre($lstService);
        }

        return $this->render('Pages/service.html.twig', [
            'service' => 'active',
            'lstTitre'=> $lstTitre,
        ]);
    }
}

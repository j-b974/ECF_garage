<?php

namespace App\Controller;

use App\Repository\DataBaseGarage;
use App\Repository\MongoGarage;
use App\Repository\TableUsedCar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SingleUsedCarController extends AbstractController
{
    #[Route('/Voiture-Occassion/{id<\d+>}', name: 'app_single_used_car')]
    public function index($id): Response
    {
        $TusedCar = new TableUsedCar(DataBaseGarage::connection());
        if(!$TusedCar->isExiteVoitureOccassionID($id))
        {
            return $this->redirectToRoute('error_id',[],302);
        }

        // récupere la voiture d'occassion
        $usedCar = $TusedCar->getUsedCarById($id);
        //====== recupere les vue de la voiture occassion =========


        return $this->render('Pages/SingleUsedCar.html.twig', [
            'usedCar' => 'active',
            'UsedCar'=> $usedCar,
            'id' => $id ,
            'image_fond'=> 'acceuilGarage.jpg'
        ]);
    }
}

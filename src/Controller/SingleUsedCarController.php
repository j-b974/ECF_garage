<?php

namespace App\Controller;

use App\Repository\DataBaseGarage;
use App\Repository\TableUsedCar;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SingleUsedCarController extends AbstractController
{
    #[Route('/Voiture-Occassion/{id}', name: 'app_single_used_car')]
    public function index($id): Response
    {
        $TusedCar = new TableUsedCar(DataBaseGarage::connection());
        $usedCar = $TusedCar->getUsedCarById($id);

        return $this->render('Pages/SingleUsedCar.html.twig', [
            'usedCar' => 'active',
            'UsedCar'=> $usedCar,
            'id' => $id
        ]);
    }
}

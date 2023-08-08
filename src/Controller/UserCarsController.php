<?php

namespace App\Controller;

use App\Repository\DataBaseGarage;
use App\Repository\TableUsedCar;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserCarsController extends AbstractController
{
    #[Route('/Voiture/Occassion', name: 'usedCar')]
    public function index(PaginatorInterface $paginator , Request $request): Response
    {
        $bdd = DataBaseGarage::connection();
        $TusedCard = new TableUsedCar($bdd);

        $lstCar = $paginator->paginate(
            $TusedCard->getAllUserCar(),// les donne a paginer
            $request->query->getInt('page',1), // donne donne l'URL pour passer a la page suivate
            10
            );

        return $this->render('Pages/usedCar.html.twig', [
            'usedCar' => 'active',
            'lstCar'=>$lstCar
        ]);
    }
}

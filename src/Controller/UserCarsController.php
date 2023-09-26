<?php

namespace App\Controller;

use App\Repository\DataBaseGarage;
use App\Repository\TableUsedCar;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/Voiture/Occassion')]
class UserCarsController extends AbstractController
{
    private $TusedCar;
    public function __construct()
    {

        $this->TusedCar = new TableUsedCar(DataBaseGarage::connection());

    }
    #[Route('/', name: 'usedCar')]
    public function index(PaginatorInterface $paginator , Request $request): Response
    {

        $param = $request->query->all();
        $param = array_filter($param,function($value){
            if((int) $value > 0) return (int) $value;

        });
        $lstCar = $paginator->paginate(
            $this->TusedCar->getAllUserCar($param),// les donne a paginer
            $request->query->getInt('page',1), // donne donne l'URL pour passer a la page suivate
            10
            );

        return $this->render('Pages/usedCar.html.twig', [
            'usedCar' => 'active',
            'minPrix' => $this->TusedCar->getMinim('prix'),
            'maxPrix'=>$this->TusedCar->getMaximun('prix'),
            'minKm'=>$this->TusedCar->getMinim('kilometrage'),
            'maxKm'=>$this->TusedCar->getMaximun('Kilometrage'),
            'minDate'=>$this->TusedCar->getMinim('annee_fabrication'),
            'maxDate'=>$this->TusedCar->getMaximun('annee_fabrication'),
            'lstCar'=>$lstCar
        ]);
    }
    #[Route('/dataUsedCar',name:'data.usedCar', methods: ['GET'])]
    public function getDataUsedCar(Request $request, ):JsonResponse
    {


        $param = $request->query->all();
        $param = array_filter($param,function($value){
            if((int) $value > 0) return (int) $value;

        });

        $data = $this->TusedCar->getAllUserCar($param);
        $jdata = [];
        if(!$data) {
            return new JsonResponse(
                ['dataUsedCar' => 'pas de donne !!!']
            );
        }
        foreach($data as $useCAR){
            $jsondata[] = json_encode($useCAR->jsonSerialize());
        }
        $dataPaste= json_encode($data[1]->jsonSerialize());

        return new JsonResponse(['dataUsedCar' => $jsondata,200]);
    }
}

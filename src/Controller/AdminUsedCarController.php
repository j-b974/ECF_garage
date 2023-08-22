<?php

namespace App\Controller;

use App\Entity\CaracteristiqueCar;
use App\Entity\ImageCar;
use App\Entity\OptionUsedCar;
use App\Entity\UsedCar;
use App\Form\CaracterisqueCarType;
use App\Form\UsedCarType;
use App\Form\OptionUsedCarType;
use App\Repository\DataBaseGarage;
use App\Repository\TableUsedCar;
use App\Services\ImageFormat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


#[Route('/admin/voiture_occassion')]
class AdminUsedCarController extends AbstractController
{
    private $TusedCar;

    public function __construct()
    {

        $this->TusedCar = new TableUsedCar(DataBaseGarage::connection());
    }

    #[Route('/', name: 'usedCar.view', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        $lstCar = $this->TusedCar->getAllUserCar();


        return $this->render('Pages/administration/usedCar/UsedCar.html.twig', [
            'adminUsedCar' => 'active',
            'lstcar' => $lstCar
        ]);
    }

    #[Route('/Creation', name: 'usedCar.create', methods: ['GET', 'POST'])]
    public function creatUserCard(Request $request, ImageFormat $imageFormat): Response
    {

        // init les classe
        $usedCar = new UsedCar();
        $option = new OptionUsedCar();
        $caracte = new CaracteristiqueCar();


        // init les form lie au class
        $form = $this->createForm(UsedCarType::class, $usedCar);
        $formOption = $this->createForm(OptionUsedCarType::class, $option);
        $formCarat = $this->createForm(CaracterisqueCarType::class, $caracte);

        $form->handleRequest($request);
        $formOption->handleRequest($request);
        $formCarat->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $formCarat->isValid()) {

            $imageUplaoder = ($form->get('lstImage')->getData());

            foreach ($imageUplaoder as $image) {
                $namefile = $imageFormat->add($image, '', 250, 250);
                $imgCar = new ImageCar();
                $imgCar->setPathImage($namefile);
                $usedCar->setImage($imgCar);
            }


            $usedCar->setCaracteristique($formCarat->getData());


            if ($formOption->isSubmitted() && $formOption->isValid()) {
                $usedCar->setOption($formOption->getData());
            }
            // percitence sur la bdd
            $this->TusedCar->addUserCar($usedCar);

            $this->addFlash('succes',
                " la voiture d’occassion #{$usedCar->getId()} a bien était créé !!!");

            return $this->redirectToRoute('usedCar.view');

        }

        return $this->render(
            'Pages/administration/usedCar/CreateUsedCar.html.twig',
            [
                'ad' => '',
                'form' => $form->createView(),
                'formOption' => $formOption->createView(),
                'fromCaract' => $formCarat->createView()
            ]

        );
    }

    #[Route('/Modier/{id}', name: 'usedCar.update', methods: ['GET', 'POST'])]
    public function Update($id , Request $request, ImageFormat $imageFormat) : Response
    {
        $usedCar = $this->TusedCar->getUsedCarById($id);
        $option = $usedCar->getOption() ?? new OptionUsedCar();
        $caracte = $usedCar->getCaracteristique() ?? new CaracteristiqueCar();



        // init les form lie au class
        $form = $this->createForm(UsedCarType::class, $usedCar);
        $formOption = $this->createForm(OptionUsedCarType::class, $option);
        $formCarat = $this->createForm(CaracterisqueCarType::class, $caracte);

        $form->handleRequest($request);
        $formOption->handleRequest($request);

        $formCarat->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() && $formCarat->isValid()) {

            $imageUplaoder = ($form->get('lstImage')->getData());

            foreach ($imageUplaoder as $image) {
                $namefile = $imageFormat->add($image, '', 250, 250);
                $imgCar = new ImageCar();
                $imgCar->setPathImage($namefile);
                $usedCar->setImage($imgCar);
            }


            $usedCar->setCaracteristique($formCarat->getData());


            if ($formOption->isSubmitted() && $formOption->isValid()) {

                $usedCar->setOption($formOption->getData());
            }else{
                // pour vidé les option
                $usedCar->setOption(new OptionUsedCar());
            }



            // percitence sur la bdd
            $this->TusedCar->updateUseCar($usedCar);

            $this->addFlash('succes',
                " la voiture d’occassion #{$usedCar->getId()} a bien était Modifié !!!");

            return $this->redirectToRoute('usedCar.view');

        }


        return $this->render('Pages/administration/usedCar/UpdateUsedCar.html.twig', [

            'usedCarImg'=>$usedCar,
            'form' => $form->createView(),
            'formOption' => $formOption->createView(),
            'fromCaract' => $formCarat->createView(),

        ]);
    }



}
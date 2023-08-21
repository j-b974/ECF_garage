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

    #[Route('/', name: 'usedCar.view',methods: ['GET','POST'])]
    public function index(): Response
    {
        $lstCar = $this->TusedCar->getAllUserCar();



        return $this->render('Pages/administration/usedCar/UsedCar.html.twig', [
            'adminUsedCar' => 'active',
            'lstcar'=> $lstCar
        ]);
    }
    #[Route('/Creation',name:'usedCar.create',methods: ['GET','POST'])]
    public function creatUserCard(Request $request, SluggerInterface $slugger , ImageFormat $imageFormat ):Response
    {

        // init les classe
        $usedCar = new UsedCar();
        $option = new OptionUsedCar();
        $caracte = new CaracteristiqueCar();

        // init les form lie au class
        $form = $this->createForm(UsedCarType::class,$usedCar);
        $formOption = $this->createForm(OptionUsedCarType::class,$option);
        $formCarat = $this->createForm(CaracterisqueCarType::class,$caracte);

        $form->handleRequest($request);
        $formOption->handleRequest($request);
        $formCarat->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() && $formCarat->isValid())
        {

            $imageUplaoder = ($form->get('lstImage')->getData());

            foreach( $imageUplaoder as $image)
            {
               $namefile =  $imageFormat->add($image, '',250 ,250);
               $imgCar = new ImageCar();
               $imgCar->setPathImage($namefile);
               $usedCar->setLstImage($imgCar);
            }


            $usedCar->setCaracteristique($formCarat->getData());


            if($formOption->isSubmitted() && $formOption->isValid())
            {
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
                'ad'=> '',
                'form' =>$form->createView(),
                'formOption'=>$formOption->createView(),
                'fromCaract'=>$formCarat->createView()
            ]

        );
    }

    /**
     * @param UploadedFile $carImage
     * @param SluggerInterface $slugger
     * @return le nom de l'image
     * @descript  sauvegard image de le reptertiore public/image_voiture_occassion
     */
    private function traitementImage(UploadedFile $carImage, SluggerInterface $slugger):string
    {
        $originalFilename = pathinfo($carImage->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$carImage->guessExtension();

        // Move the file to the directory where brochures are stored
        try {
            $carImage->move(
                $this->getParameter('imageCar_directory'),
                $newFilename
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        // updates the 'brochureFilename' property to store the PDF file name
        // instead of its contents

        return $newFilename;
    }
}

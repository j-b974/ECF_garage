<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use App\Repository\DataBaseGarage;
use App\Repository\TableAvis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function new(Request $request):Response
    {
        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);//  attention rendre creatView et non $form !!!

        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $bdd = DataBaseGarage::connection();
            $Tavis = new TableAvis($bdd);
            $Tavis->addAvis($form->getData());

            // lance un event a travers symfony
            // ecouteur sur templete => admin_avis
            $this->addFlash('succes',
              " l'Avis #{$form->getData()->getId()} a bien était créé !!!");
            return $this->redirectToRoute('admin_avis');
        }

        return $this->render('Pages/administration/CreatAvis.html.twig',[
            'AvisForm' =>$form->createView()// important !!!
        ]);
    }

}

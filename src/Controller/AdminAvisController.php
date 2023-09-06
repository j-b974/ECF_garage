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

#[Route('/admin/avis')]
class AdminAvisController extends AbstractController
{
    public function __construct()
    {

    }
    /**
     * Vue initiale
     * @return Response
     */
    #[Route('/', name: 'admin_avis',methods: ['GET','POST'])]
    public function index(): Response
    {
        $bdd = DataBaseGarage::connection();
        $Tavis = new TableAvis($bdd);
        $lstAvis = $Tavis->getAllAvis();
        return $this->render('Pages/administration/AvisAdmin.html.twig', [
            'adminAvis' => 'active',
            'lstAvis'=>$lstAvis
        ]);
    }

    /**
     * Vue Creation Avis
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    #[Route('/Creation', name:'create_avis', methods: ['GET','POST'])]
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

            // lance un message_event a travers symfony
            // ecouteur sur templete => admin_avis
            $this->addFlash('succes',
              " l'Avis #{$form->getData()->getId()} a bien était créé !!!");
            return $this->redirectToRoute('admin_avis');
        }

        return $this->render('Pages/administration/CreatAvis.html.twig',[
            'AvisForm' =>$form->createView()// important !!!
        ]);
    }
    #[Route('/Modification/{id}',name:'update_avis',methods:['GET','POST'])]
    public function update(Request $request, $id):Response
    {
        $bdd = DataBaseGarage::connection();
        $Tavis = new TableAvis($bdd);
        $avis = $Tavis->getAvisById($id);

        $form = $this->createForm(AvisType::class,$avis);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $Tavis->updateAvis($avis);
            $this->addFlash('succes',
                " l'Avis #{$form->getData()->getId()} a était modifier avec succée !!!");
            return $this->redirectToRoute('admin_avis');
        }

        return $this->render('Pages/administration/UpdateAvis.html.twig',[
                'AvisForm'=>$form->createView()
        ]);
    }

    /**
     * Suppréssion de l'avis
     * @param $id
     * @return Response
     * @throws \Exception
     */
    #[Route('/Suppression/{id}',name:'delete_avis',methods: ['GET'])]
    public function delete($id):Response
    {
        $bdd = DataBaseGarage::connection();
        $Tavis = new TableAvis($bdd);
        $Tavis->delecte($id);
        $this->addFlash('succes',
            " l'Avis #$id a était supprimer avec succée !!!");

        return $this->redirectToRoute('admin_avis');
    }

}

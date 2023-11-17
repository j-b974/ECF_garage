<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use App\Repository\DataBaseGarage;
use App\Repository\TableAvis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/admin/avis')]
class AdminAvisController extends AbstractController
{
    private  $Tavis ;
    public function __construct()
    {
        $this->Tavis = new TableAvis(DataBaseGarage::connection());
    }
    /**
     * Vue initiale
     * @return Response
     */
    #[Route('/', name: 'admin_avis',methods: ['GET','POST'])]
    public function index(): Response
    {
        $lstAvis = $this->Tavis->getAllAvis();
        $lstNewAvis = array_filter($lstAvis, function($avis){
            if($avis->getStatus() == 'nouveau') return true;
        });
        $lstAvis = array_filter($lstAvis , function($avis){
            if($avis->getStatus()!= 'nouveau') return true;
        });
        return $this->render('Pages/administration/AvisAdmin.html.twig', [
            'adminAvis' => 'active',
            'lstAvis'=>$lstAvis,
            'lstNewAvis'=>$lstNewAvis
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
    #[Route('/Modification/{id<\d+>}',name:'update_avis',methods:['GET','POST'])]
    public function update(Request $request, $id):Response
    {
        if(!$this->Tavis->isExiteAvisId($id))
        {
            return $this->redirectToRoute('error_id',[],302);
        }

        $avis = $this->Tavis->getAvisById($id);

        $form = $this->createForm(AvisType::class,$avis);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->Tavis->updateAvis($avis);
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
    #[Route('/Suppression/{id<\d+>}',name:'delete_avis',methods: ['DELETE'])]
    public function delete($id , Request $request):JsonResponse
    {
        if(!$this->Tavis->isExiteAvisId($id))
        {
            return new JsonResponse(['error'=> 'identifiant introuvalbe !!!']);
        }
        $avis = $this->Tavis->getAvisById($id);
        $data = json_decode($request->getContent(),true);

        if(isset($data['_token']) && $this->isCsrfTokenValid('delete'.$avis->getId(), $data['_token']) ) {

            $this->Tavis->delecte($id);
            return new JsonResponse(['success'=>true,'message'=> "l'avis #$id a bien était supprimé !"],200);


        }
        return new JsonResponse(["error"=> "token non valide !!!"],401);
    }

    #[Route('/publier/{id<\d+>}', name:'publie_avis', methods: ['POST'])]
    public function publish($id , ValidatorInterface $validator , Request $request ):JsonResponse
    {
        if(!$this->Tavis->isExiteAvisId($id))
        {
            return new JsonResponse(['error'=> 'identifiant introuvalbe !!!']);
        }
        
        $avis = $this->Tavis->getAvisById( (int) $id);
        if(!$avis){ return new JsonResponse(['error'=> 'identification incorrecte !!! '],401 );}
        $data = json_decode($request->getContent(),true);
        // verification du token
        if(isset($data['_token']) && $this->isCsrfTokenValid('publish'.$avis->getId(), $data['_token']) ) {
            $avis->setStatus($data['_status']);
            // verification des données
            if ($validator->validate($avis)) {

                $this->Tavis->updateAvis($avis);
                return new JsonResponse(['success'=> true,'message'=> " l'Avis #{$avis->getId()} a bien était publier !!!"]);
            }
            return new JsonResponse(['error'=> json_encode($avis)],401 );
        }
        return new JsonResponse(['error'=> 'token non valide'],401 );
    }
    #[Route('/nombre_New',name:'count.avis',methods: ['GET'])]
    public function countAvis ():JsonResponse
    {
        $count = $this->Tavis->getCountNewAvis();
        return new JsonResponse(['nbCountAvis'=>$count],200);
    }

}

<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\DataBaseGarage;
use App\Repository\TableUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCompteController extends AbstractController
{
    private $Tuser;
    public function __construct()
    {
        $this->Tuser = new TableUser(DataBaseGarage::connection());
    }
    #[Route('/admin/compte', name: 'app_admin_compte')]
    public function index(): Response
    {

        $listUser = $this->Tuser->getAllUser();

        return $this->render('Pages/administration/compte/compte.html.twig', [
            'controller_name' => 'AdminCompteController',
            'listUser' => $listUser
        ]);
    }
    #[Route('/admin/Ajouter',name:'ajoute_compte',methods: ['GET','POST'])]

    public function ajouter(Request $request):Response
    {
        $user = new User();
        $form = $this->createForm( UserFormType::class , $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if(!$this->Tuser->isUserExite($user)){

                $this->Tuser->addUser($user);
                $this->addFlash('succes',
                    " Utilisateur  #{$user->getIdentifiantId()} a était ajouter avec succé !!!");
                return $this->redirectToRoute('app_admin_compte');
            }
            $this->addFlash('danger',
                " l' Adresse Email  #{$form->getData()->getAdressEmail()} exite déjà !!!");
        }

        return $this->render('Pages/administration/compte/AjouteCompte.html.twig',[
            'form'=> $form->createView()
        ]);
    }
    #[Route('/admin/modifier/{id}',name:'modifier_compte',methods: ['GET','POST'])]
    public function modifier( $id , Request $request):Response
    {
        $user = $this->Tuser->getUserById($id);

        $form = $this->createForm( UserFormType::class , $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->Tuser->updateUser($user);
            $this->addFlash('succes',
                " Utilisateur  #{$user->getIdentifiantId()} a était Modifier avec succé !!!");
            return $this->redirectToRoute('app_admin_compte');
        }
        return $this->render('Pages/administration/compte/modifierCompte.html.twig',[
            'form'=> $form->createView()
        ]);
    }
    #[Route('/admin/supprime/{id}', name:'supprime_compte', methods: ['DELETE'])]
    public function delete($id , Request $request):JsonResponse
    {
        $user = $this->Tuser->getUserById($id);
        $data = json_decode($request->getContent(),true);

        if(isset($data['_token']) && $this->isCsrfTokenValid('delete'.$user->getIdentifiantId(), $data['_token'])){
            $this->Tuser->deleteUser($user);
            return new JsonResponse(['success'=> true , 'message' => "le compte {$user->getAdressEmail()} bien était supprimé !!!"]);
        }

            return new JsonResponse(['error'=>'token non valide'],401);
    }
}

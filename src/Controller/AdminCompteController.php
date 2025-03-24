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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/compte')]
class AdminCompteController extends AbstractController
{
    private $Tuser;
    public function __construct()    {
        $this->Tuser = new TableUser(DataBaseGarage::connection());
    }
    #[Route('/', name: 'app_admin_compte')]
    public function index(): Response
    {
        if($this->getUser()->getRole()!= 'Administrateur'){

           return $this->redirectToRoute('app_admin_contact');
        };
        $listUser = $this->Tuser->getAllUser();

        return $this->render('Pages/administration/compte/compte.html.twig', [
            'controller_name' => 'AdminCompteController',
            'listUser' => $listUser
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/Ajouter',name:'ajoute_compte',methods: ['GET','POST'])]
    public function ajouter(Request $request,UserPasswordHasherInterface $hasher):Response
    {
        if($this->getUser()->getRole()!= 'Administrateur'){
            return  $this->redirectToRoute('app_admin_contact');
        };
        $user = new User();
        $form = $this->createForm( UserFormType::class , $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if(!$this->Tuser->isUserExite($user)){
                // hash password
                $user->setPassword($hasher->hashPassword($user , $user->getPassword()));
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
    #[Route('/modifier/{id<\d+>}',name:'modifier_compte',methods: ['GET','POST'])]
    public function modifier( $id , Request $request, UserPasswordHasherInterface $hasher):Response
    {
        if($this->getUser()->getRole()!= 'Administrateur'){
            return  $this->redirectToRoute('app_admin_contact');
        };
        if(!$this->Tuser->isExiteUserById($id))
        {
            return $this->redirectToRoute('error_id',[],302);
        }

        $user = $this->Tuser->getUserById($id);

        $form = $this->createForm( UserFormType::class , $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user->setPassword($hasher->hashPassword($user , $user->getPassword()));
            $this->Tuser->updateUser($user);
            $this->addFlash('succes',
                " Utilisateur  #{$user->getIdentifiantId()} a était Modifier avec succé !!!");
            return $this->redirectToRoute('app_admin_compte');
        }
        return $this->render('Pages/administration/compte/modifierCompte.html.twig',[
            'form'=> $form->createView()
        ]);
    }
    #[Route('/supprime/{id<\d+>}', name:'supprime_compte', methods: ['DELETE'])]
    public function delete($id , Request $request):JsonResponse
    {
        if($this->getUser()->getRole()!= 'Administrateur'){
            return $this->redirectToRoute('app_admin_contact');
        };
        if(!$this->Tuser->isExiteUserById($id))
        {
            return new JsonResponse(['error'=> 'identifiante introuvable']);
        }
        $user = $this->Tuser->getUserById($id);
        $data = json_decode($request->getContent(),true);

        if(isset($data['_token']) &&
            $this->isCsrfTokenValid('delete'.$user->getIdentifiantId(), $data['_token'])){
            $this->Tuser->deleteUser($user);
            return new JsonResponse(['success'=> true ,
                'message' => "le compte {$user->getAdressEmail()} bien était supprimé !!!"]);
        }

            return new JsonResponse(['error'=>'token non valide'],401);
    }
}

<?php

namespace App\Controller;

use App\Repository\DataBaseGarage;
use App\Repository\TableContact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('admin/contact')]
class AdminContactController extends AbstractController
{
    private $Tcontact;
    public function __construct()
    {
        $this->Tcontact = new TableContact(DataBaseGarage::connection());
    }
    #[Route('/', name: 'app_admin_contact')]
    public function index(): Response
    {
        $lstContact = $this->Tcontact->getAllContact();
        $lstNewContact = array_filter($lstContact , function($contact){
            if($contact->getEtat()== 'nouveau') return true;
        });
        $lstContact = array_filter($lstContact , function($contact){
            if($contact->getEtat()!= 'nouveau') return true;
        });
        $countContact = $this->Tcontact->getCountNewContact();


        return $this->render('Pages/administration/contact/contact.html.twig', [
            'controller_name' => 'AdminContactController',
            'lstContact'=> $lstContact,
            'lstNewContact'=>$lstNewContact,
            'nbNewContact'=>$countContact
        ]);
    }
    #[Route('/{id}', name:'single_contact', methods:['GET','POST']) ]
    public function singleContact($id):Response
    {
        $contact = $this->Tcontact->getContactById((int) $id);

        return $this->render('Pages/administration/contact/singleContact.html.twig',[
            'contact'=>$contact
        ]);
    }
    #[Route('/Modification/{id}', name:'modif_etat',methods: ['GET'])]
    public function modifEtat($id, Request $request , ValidatorInterface $validator)
    {

        $contact = $this->Tcontact->getContactById((int)$id);

        $contact->setEtat($request->query->get('etat'));
        if($validator->validate($contact)){
            $this->Tcontact->updateContact($contact);
        }

        return $this->redirectToRoute('app_admin_contact');

    }
    #[Route('/count/contact', name:'count.contact', methods: ['GET'])]
    public function countContact()
    {
        $count = $this->Tcontact->getCountNewContact();
        return new JsonResponse(['nbContact'=>$count],200);
    }
    #[Route('/suppression/{id}',name:'supprime.contact', methods: ['DELETE'])]
    public function deletContact($id , Request $request):JsonResponse
    {
        $contact = $this->Tcontact->getContactById($id);
        $data = json_decode($request->getContent(),true);

        if(isset($data['_token']) && $this->isCsrfTokenValid('delete'.$contact->getId(), $data['_token']) ){

            $this->Tcontact->deleteContact($contact);
            return new JsonResponse(['success'=>true ,'message'=> " le message Contact #{$contact->getId()} a était supprimer avec succée !!!"],200);
        }

        return new JsonResponse(['error'=> 'token invalide'],401);
    }
}

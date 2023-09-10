<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\DataBaseGarage;
use App\Repository\TableContact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods:['POST','GET']) ]
    public function index(Request $request , ValidatorInterface $validator): Response
    {

        if( $this->isCsrfTokenValid('authenticate', $request->request->get('_csrf_token')) ) {

            $contact = new Contact();
            $contact->setNom($request->request->get('nom'))
                ->setPrenom($request->request->get('prenom'))
                ->setAdressEmail($request->request->get('adressEmail'))
                ->setNumeroTelephone($request->request->get('numero_telephone'))
                ->setMessage($request->request->get('message'));


            $TContact = new TableContact(DataBaseGarage::connection());
            $erro =[...$validator->validate($contact)];

            if(count($erro)>0){

                $this->addFlash('danger',
                    'Erreur champ invalide : ');

                return $this->redirectToRoute($request->request->get('namePage'));
            }else{
                $TContact->addContact($contact);
            }


            $this->addFlash('succes',
                " votre message à bien était transmie !!!");
        }else{

        }
        return $this->redirectToRoute($request->request->get('namePage'));
    }
}

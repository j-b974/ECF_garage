<?php

namespace App\Controller;

use App\Entity\Service;
use App\Repository\DataBaseGarage;
use App\Repository\TableService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/admin/service')]
class AdminServiceController extends AbstractController
{
    private $Tservice ;

    public function __construct()
    {
        $this->Tservice = new TableService(DataBaseGarage::connection());
    }

    #[Route('/', name: 'app_admin_service',methods: ['GET'])]
    public function index(): Response
    {
        $lstTire = [];
        foreach( $this->Tservice->getAllTitreService() as $lstService)
        {
            $lstTitre[$lstService] = $this->Tservice->getAllServiceByTitre($lstService);
        }

        return $this->render('Pages/administration/serviceGarage/serviceGarage.html.twig', [
            'controller_name' => 'AdminServiceController',
            'lstTitre'=>$lstTitre
        ]);
    }
    #[Route('/rajoute', name:'add_service', methods: ['POST','GET'])]
    public function addService(Request $request, ValidatorInterface $validator):Response
    {


        if(!empty($request->request->all()))
        {

            $titre = $request->request->get('titre');
            // redirige si le titre exite déjà
            if(!$this->Tservice->isTitreExite($titre))
            {
                $this->Tservice->addTitreService($titre);
            }else{
                //TODO retourne les erreurs a la vue !!!
                $this->addFlash('danger',
                    " le nom du titre est déjà utiliser");
                return $this->redirectToRoute('add_service');
            }
            // créé les service puis l'envoye a la bdd
            $this->addServiceData($request ,$validator);

            $this->addFlash('succes',
                " le service $titre à bien était créer !!!");
            return $this->redirectToRoute('app_admin_service');
        }
        return $this->render('Pages/administration/serviceGarage/addServiceGarage.html.twig');
    }


    #[Route('/Modifier/', name:'modifier_service', methods: ['GET','POST'])]
    public function modiferService( Request $request):Response
    {

        $titre = $request->query->get('titre');
        $lstService = $this->Tservice->getAllServiceByTitre($titre);
        if(empty($lstService)){
            return $this->redirectToRoute('add_service',['titre'=> $titre]);
        }

        $data = $request->request->all();

        if(!empty($data))
        {
            $newTitre = $request->request->get('titre');
            $modifTitre = $this->Tservice->isTitreExite($newTitre);

            if(!$modifTitre)
            {
                // modification du titre
                $this->Tservice->addTitreService($newTitre);
            }

            $lstService = [];
            // titre non modifier
            foreach( $data['nomService'] as $key => $value)
            {
                $service = new Service();
                $service->setId($key)
                    ->setTitre($newTitre)
                    -> setNomService($value);
                $lstService[] = $service;
            }

            foreach($data['labelPrix'] as $key => $label)
            {
                foreach($lstService as $service)
                {
                    // modification service exitant déjà
                    if($service->getId() == $key)
                    {
                        $service->setLabelPrix($label);
                        $this->Tservice->updateService($service);
                    }
                    // insert new service
                    if($service->getId() == 0)
                    {
                        if($service->getNewId()== $key){
                            $service->setLabelPrix($label);
                            $this->Tservice->addService($service);
                        }
                    }
                }
            }

            // supprime ancienne titre
            if(!$modifTitre)
            {
                $this->Tservice->deleteTitreService($titre);
            }else{

                $this->Tservice->deleteServiceNotList($lstService);
            }

            $this->addFlash('succes',
                " le service $titre à bien était modifier !!!");
            return $this->redirectToRoute('app_admin_service');
        }

        return $this->render('Pages/administration/serviceGarage/updateServiceGarage.html.twig',[
            'lstService'=> $lstService
        ]);
    }
    #[Route('/delete/', name:'delete_service' , methods: ['DELETE'])]
    public function deleteService(Request $request):JsonResponse
    {
        // recupere les donne de la requette
        $data = json_decode($request->getContent(),true);

        $titre = $data['_titre'];

        if(isset($data['_token']) && $this->isCsrfTokenValid('delete', $data['_token']) )
        {
            // suppression de donne
            if($this->Tservice->isTitreExite($titre))
            {
                $this->Tservice->deleteTitreService($titre);
                return new JsonResponse(['success'=>true,'message'=>" le service $titre a était totalement supprimé !!! "],200);
            }
        }
        return new JsonResponse(['error'=>'Token non valide !!!'],401);
    }
    private function addServiceData( $request , $validator )
    {
        // créé liste service appartir $date request
        $lstService = array_map(function ($key){
            $service = new Service();
            $service->setNomService($key);
            return $service ;
        },$request->request->all()['nomService'] );

        foreach ($lstService as $key=> $service)
        {
            $service->setTitre($request->request->get('titre'));
            $service->setLabelPrix( $request->request->all()['labelPrix'][$key]);

            if($validator->validate($service)){
                $this->Tservice->addService($service);
            }
        }
    }
}

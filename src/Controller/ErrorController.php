<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    #[Route('/Page/introuvable', name: 'app_error',methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Pages/errors/error.html.twig', [
            'controller_name' => 'ErrorController',
        ]);
    }
    #[Route('/Identifiant/introuvable', name: 'error_id',methods:['GET'])]
    public function errorId():Response
    {
       return $this->render('Pages/errors/errorId.html.twig');
    }
}

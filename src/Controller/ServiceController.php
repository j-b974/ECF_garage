<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'service',methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Pages/service.html.twig', [
            'service' => 'active',
        ]);
    }
}

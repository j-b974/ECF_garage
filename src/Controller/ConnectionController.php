<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConnectionController extends AbstractController
{
    #[Route('/connection', name: 'connection',methods: ['GET','POST'])]
    public function index(): Response
    {
        return $this->render('Pages/connection.html.twig', [
            'connection' => 'connection',
        ]);
    }
}
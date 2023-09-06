<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCompteController extends AbstractController
{
    #[Route('/admin/compte', name: 'app_admin_compte')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_DIRECTEUR');

        return $this->render('Pages/administration/compte/compte.html.twig', [
            'controller_name' => 'AdminCompteController',
        ]);
    }
}

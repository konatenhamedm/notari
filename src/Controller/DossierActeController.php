<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DossierActeController extends AbstractController
{
    /**
     * @Route("/dossier/acte", name="app_dossier_acte")
     */
    public function index(): Response
    {
        return $this->render('dossier_acte/index.html.twig', [
            'controller_name' => 'DossierActeController',
        ]);
    }
}

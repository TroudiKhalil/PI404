<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }
    
        #[Route('/Doctors', name: 'app_Doctor')]
        public function Doctors(): Response
        {
            return $this->render('home/doctor.html.twig');
        }
        #[Route('/homereclamation', name: 'app_reclamation')]
        public function goReclamation(): Response
        {
            return $this->render('home/Reclamation.html.twig');
        }
}


<?php

namespace App\Controller;
use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name:"app_admin", methods:['GET'])]

    public function admin(): Response
    {
        return $this->render('admin.html.twig');
    }
    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        return $this->render('admin/profile.html.twig');
    }

    #[Route('/dash', name: 'app_dashboard')]
    public function dash(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }
    #[Route('/test', name: 'app_test')]
    public function test(): Response
    {
        return $this->render('admin/test.html.twig');
    }
    #[Route('/tables', name: 'app_tables')]

    public function listadmin(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $posts = $entityManager->getRepository(Post::class)->findAll();
        return $this->render('admin/table-basic.html.twig', [
            "posts" => $posts,
        ]);
    }
       
}

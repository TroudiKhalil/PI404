<?php

namespace App\Controller;
use App\Entity\Post;
use App\Entity\Postcomment;
use Symfony\Component\HttpFoundation\Request;

use App\Form\PostType;
use App\Repository\PostRepository;
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

    public function listadmin(Request $request,PostRepository $repository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $posts = $entityManager->getRepository(Post::class)->findAll();
        $back = null;
            
            if($request->isMethod("POST")){
                if ( $request->request->get('optionsRadios')){
                    $SortKey = $request->request->get('optionsRadios');
                    switch ($SortKey){
                        case 'title':
                            $posts = $repository->SortBytitle();
                            break;
             
                    }
                }
                else
                {
                    $type = $request->request->get('optionsearch');
                    $value = $request->request->get('Search');
                    switch ($type){
                        case 'title':
                            $posts = $repository->findBytitle($value);
                            break;
    
                        
    
                    }
                }

                if ( $posts){
                    $back = "success";
                }else{
                    $back = "failure";
                }
            }
        return $this->render('admin/table-basic.html.twig', [
            "posts" => $posts,
            'back'=>$back
        ]);
    }
    #[Route('/tablecomment', name: 'comment')]

    public function comment(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Postcomment::class)->findAll();
        return $this->render('admin/tablecomment.html.twig', [
            "comments" => $comment,
        ]);
    }
       
}

<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Postcomment;
use App\Form\PostType;
use App\Form\PostcommentType;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
#[Route('/Post')]

class PostController extends AbstractController
{
    #[Route('/', name: 'homepage')]

    public function indexAction(ManagerRegistry $doctrine, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $posts=$em->getRepository(Post::class)->findAll();
        return $this->render('base.html.twig', array(
            "posts" =>$posts
        ));
    }
    #[Route('/home', name: 'home')]

    public function home(ManagerRegistry $doctrine, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $posts=$em->getRepository(Post::class)->findAll();
        return $this->render('base2.html.twig', array(
            "posts" =>$posts
        ));
    }
    #[Route('/addpost', name: 'Create_post', methods: ["GET","POST"])]

    public function addAction(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('photo')->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->getClientOriginalExtension();
                $imageFile->move(
                    $this->getParameter('app.photos_directory'),
                    $newFilename
                );
                $post->setPhoto($newFilename);
            }
            $post->setCreator($this->getUser());
            $post->setPostdate(new \DateTime('now'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('info', 'Created Successfully !');
        }
        return $this->render('Post/add.html.twig', [
            "Form" => $form->createView(),
            'post' => $post,

        ]);
    }
    #[Route('/list_post', name: 'list_post')]

    public function listpostAction(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $posts = $entityManager->getRepository(Post::class)->findAll();
        return $this->render('Post/list.html.twig', [
            "posts" => $posts,
        ]);
    }

  
    #[Route('/update_post/{id}', name: 'update_post')]

    public function updatepostAction(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $post = $entityManager->getRepository(Post::class)->find($id);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('photo')->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->getClientOriginalExtension();
                $imageFile->move(
                    $this->getParameter('app.photos_directory'),
                    $newFilename
                );
                $post->setPhoto($newFilename);
            }
            $post->setPostdate(new \DateTime('now'));
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('list_post');
        }
        return $this->render('Post/update.html.twig', [
            "form" => $form->createView(),
        ]);
    }
    #[Route('/delete_post/{id}', name: 'delete_post')]

    public function deletepostAction(Request $request): Response
    {
        $id = $request->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $post = $entityManager->getRepository(Post::class)->find($id);
        $entityManager->remove($post);
        $entityManager->flush();
        return $this->redirectToRoute('list_post');
    }
    #[Route('/detailed_post/{id}', name: 'detailed_post')]

    public function showdetailedAction($id,Request $request, UserInterface $user): Response
    {
        $comment = new Postcomment();
                $form = $this->createForm(PostcommentType::class, $comment);
                $form->handleRequest($request);
                $entityManageree=$this->getDoctrine()->getManager();
                $post = $entityManageree->getRepository(Post::class)->find($id);
                if ($form->isSubmitted() && $form->isValid()) {
                    $comment->setUser($user);
                    $comment->setPost($post);
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($comment);
                    $entityManager->flush();
                    $this->addFlash('info', 'Comment Added Successfully !');
                }
        $entityManagere = $this->getDoctrine()->getManager();
        $post = $entityManagere->getRepository(Post::class)->find($id);
        return $this->render('Post/detailedpost.html.twig', [
            'title' => $post->getTitle(),
            'date' => $post->getPostdate(),
            'photo' => $post->getPhoto(),
            'descripion' => $post->getDescription(),
            'posts' => $post,
            'comments' => $post,
            'id' => $post->getId(),
            'form'=>$form->createView(),
            ]);
        
    }
            #[Route('/search', name: 'search')]

            public function searchAction(Request $request)
            {
                $em = $this->getDoctrine()->getManager();
                $requestString = $request->get('q');
                $posts = $em->getRepository(Post::class)->findEntitiesByString($requestString);
                if (!$posts) {
                    $result['posts']['error'] = "Post not found :(";
                } else {
                         $result['posts'] = $this->getRealEntities($posts);
                       }
                return new Response(json_encode($result));
            }
              
            public function getRealEntities($posts)
            {
                foreach ($posts as $post) {
                    $realEntities[$post->getId()] = [$post->getPhoto(), $post->getTitle()];
                }
            return $realEntities;
            }
         #[Route('/delete', name: 'delete_comment')]

         public function deleteCommentAction(Request $request)
        {
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            $comment = $em->getRepository(Postcomment::class)->find($id);
            $em->remove($comment);
            $em->flush();
            return $this->redirectToRoute('list_post');
        }

            
}            
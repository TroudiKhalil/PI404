<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Postcomment;
use App\Form\PostType;
use App\Form\PostcommentType;
use App\Repository\PostRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PostJsonController extends AbstractController
{
    #[Route('/lol', name: 'list_postjson')]

    public function listpostActionjson(Request $request,NormalizerInterface $normalizer,SerializerInterface $serializer, PostRepository $PostRepository, PaginatorInterface $paginator): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $posts = $entityManager->getRepository(Post::class)->findAll();

             //* students en  tableau associatif simple.
        $studentsNormalises = $normalizer->normalize($posts, 'json', ['groups' => "Post"]);

        // //* Nous utilisons la fonction json_encode pour transformer un tableau associatif en format JSON
        $json = json_encode($studentsNormalises);

        //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON
        return new Response($json);
    }
    #[Route('/addpostjs', name: 'Create_postjs', methods: ["GET","POST"])]

    public function addActionjs(Request $request,NormalizerInterface $normalizer)
    {   
        $data = json_decode($request->getContent(), true);

        $post = new Post();
        $post->setTitle($data['title']);
    $post->setDescription($data['description']);
            $imageFile = $data['photo'];
            if ($imageFile) {
                $imageData = base64_decode($imageFile);

                $fileName = uniqid() . '.jpeg'; // You can also use the original file extension if you have it
                        $filePath = $this->getParameter('app.photos_directory') . '/' . $fileName;

                    file_put_contents($filePath, $imageData);
                    $post->setPhoto($fileName);

            }
            $post->setCreator($this->getUser());
            $post->setPostdate(new \DateTime('now'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
            
            $this->addFlash('info', 'Created Successfully !');
        
        $studentsNormalises = $normalizer->normalize($post, 'json', ['groups' => "Post"]);

        // //* Nous utilisons la fonction json_encode pour transformer un tableau associatif en format JSON
        $json = json_encode($studentsNormalises);
        return new Response($json);

    }
#[Route('/addpostjss', name: 'Create_postjss', methods: ["GET","POST"])]

    public function ferActionjs(Request $request,NormalizerInterface $normalizer)
    {   
    $Post = new Post();
        $title = $request->get("title");
        $description = $request->get("description");
        $Post->setPostdate(new \DateTime('now'));

        $Post->setTitle($title);
        $Post->setDescription($description);
        $imageFile = $request->get('photo')->getData();
        if ($imageFile) {
            $newFilename = uniqid().'.'.$imageFile->getClientOriginalExtension();
            $imageFile->move(
                $this->getParameter('app.photos_directory'),
                $newFilename
            );
            $Post->setPhoto($newFilename);
        }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Post);
            $entityManager->flush();
            
            $this->addFlash('info', 'Created Successfully !');
        
        $studentsNormalises = $normalizer->normalize($Post, 'json', ['groups' => "Post"]);

        // //* Nous utilisons la fonction json_encode pour transformer un tableau associatif en format JSON
        $json = json_encode($studentsNormalises);
        return new Response($json);
 }
    #[Route('/updatepostjs/{id}', name: 'update_postjs', methods: ["GET","POST"])]

    public function updateActionjs(Request $request,NormalizerInterface $normalizer,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $Post = $entityManager->getRepository(Post::class)->find($id);
        $title = $request->get("title");
        $description = $request->get("description");
        $Post->setPostdate(new \DateTime('now'));

        $Post->setTitle($title);
        $Post->setDescription($description);
        $imageFile = $request->get('photo')->getData();
        if ($imageFile) {
            $newFilename = uniqid().'.'.$imageFile->getClientOriginalExtension();
            $imageFile->move(
                $this->getParameter('app.photos_directory'),
                $newFilename
            );
            $Post->setPhoto($newFilename);
        }
            $Post->setCreator($this->getUser());
            $Post->setPostdate(new \DateTime('now'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Post);
            $entityManager->flush();
            
            $this->addFlash('info', 'Created Successfully !');
        
        $studentsNormalises = $normalizer->normalize($Post, 'json', ['groups' => "Post"]);

        // //* Nous utilisons la fonction json_encode pour transformer un tableau associatif en format JSON
        $json = json_encode($studentsNormalises);
        return new Response($json);

    }   
    #[Route('/delete_postjson/{id}', name: 'delete_postjson', methods: ["GET","POST"])]

    public function deletepostAction(Request $request,NormalizerInterface $normalizer): Response
    {
        $id = $request->get('id');
        $entityManager = $this->getDoctrine()->getManager();
        $post = $entityManager->getRepository(Post::class)->find($id);
        $entityManager->remove($post);
        $entityManager->flush();
        $studentsNormalises = $normalizer->normalize($post, 'json', ['groups' => "Post"]);
        $json = json_encode($studentsNormalises);
        return new Response($json);
}
#[Route('/detailed_postjson/{id}', name: 'detailed_postjson', methods: ["GET","POST"])]
public function showdetailedActionjson($id,Request $request,NormalizerInterface $normalizer): Response
{
$comment = new Postcomment();
$entityManageree=$this->getDoctrine()->getManager();
$post = $entityManageree->getRepository(Post::class)->find($id);
$content = $request->get("content");
$comment->setContent($content);
$comment->setPostedAt(new \DateTime('now'));
$comment->setPost($post);
$entityManager = $this->getDoctrine()->getManager();
$entityManager->persist($comment);
$entityManager->flush();
$this->addFlash('info', 'Comment Added Successfully !'); 
$comments = $entityManager->getRepository(Postcomment::class)->findBy(['post' => $post]);
$postData = $normalizer->normalize($post, 'json', ['groups' => 'Post']);
$commentsData = $normalizer->normalize($comments, 'json', ['groups' => 'Comment']);

$response = [
    'post' => $postData,
    'comments' => $commentsData,
];
$json = json_encode($response);
return new Response($json);
}
    #[Route('/admin/postcommentsjson/approve/{id}', name: 'admin_postcommentsjson_approve')]
    public function approvejson(Request $request,NormalizerInterface $normalizer,$id): Response
    {   $entityManager = $this->getDoctrine()->getManager();

        $postComment = $entityManager->getRepository(Postcomment::class)->find($id);

        $postComment->setApproved(true);
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($postComment);
        $entityManager->flush();
        $commentsData = $normalizer->normalize($postComment, 'json', ['groups' => 'Comment']);
        $json = json_encode($commentsData);
        return new Response($json);
    }

}

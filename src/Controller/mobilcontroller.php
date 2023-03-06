<?php

namespace App\Controller;

use App\Entity\User;
//use App\Entity\Postcomment; lentite 2
use App\Form\RegistrationFormType;
//use App\Form\PostcommentType;
use App\Repository\UserRepository;
//use Doctrine\ORM\Tools\Pagination\Paginator; page1.2.3
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

class mobilcontroller extends AbstractController
{
    #[Route('/lol', name: 'list_postjson')]

    public function listpostActionjson(Request $request,NormalizerInterface $normalizer,SerializerInterface $serializer, UserRepository $UserRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $User = $entityManager->getRepository(User::class)->findAll();

             //* students en  tableau associatif simple.
        $studentsNormalises = $normalizer->normalize($User, 'json', ['groups' => "User"]);

        // //* Nous utilisons la fonction json_encode pour transformer un tableau associatif en format JSON
        $json = json_encode($studentsNormalises);

        //* Nous renvoyons une réponse Http qui prend en paramètre un tableau en format JSON
        return new Response($json);
    }
    #[Route('/adduser', name: 'Create_user', methods: ["POST","User"])]

    public function addActionjs(Request $request,NormalizerInterface $normalizer)
    {   
$User = new User();
        
        
        $email = $request->request->get("email");
        $password = $request->request->get("password");
    
        $User->setEmail($email);
        $User->setPassword($password);
            

            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($User);
            $entityManager->flush();
            
            $this->addFlash('info', 'Created Successfully !');
        
        $studentsNormalises = $normalizer->normalize($User, 'json', ['groups' => "User"]);

        // //* Nous utilisons la fonction json_encode pour transformer un tableau associatif en format JSON
        $json = json_encode($studentsNormalises);
        return new Response($json);
 }
}
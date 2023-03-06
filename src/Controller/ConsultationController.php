<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsultationController extends AbstractController
{
    /*#[Route('/consultation', name: 'app_consultation')]
    public function index(): Response
    {
        return $this->render('consultation/index.html.twig', [
            'controller_name' => 'ConsultationController',
        ]);
        kkl
    }*/
    #[Route('/meet/{id_User}/{id_medcin}', name: 'app_meet')]
    public function meet($id_User, $id_medcin)
    {$uniqueurl = strval(uniqid());
       // $meetLink = "https://meet.google.com/".$id_User."-".$id_medcin;
      //  return $this->render('consultation/index.html.twig', [
           // 'meetLink' => $uniqueurl,
      //  ]);
      
        $uniqueurl = strval(uniqid());
$meetlink = "https://meet.jit.si/".$uniqueurl;
//return $this->render('consultation/index.html.twig', [ 'user' => $id_User , 'medcin' => $id_medcin]);
return $this->redirect($meetlink);
    }
}

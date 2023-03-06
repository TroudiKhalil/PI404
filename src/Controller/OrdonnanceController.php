<?php

namespace App\Controller;

    //const PATH_PDF = "../pdf/";
use Knp\Snappy\Pdf;
use App\Entity\Ordonnance;
use App\Form\OrdonnanceType;
use App\Repository\OrdonnanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
Use App\Controller\EntityManagerInterface;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

use Twig\Environment;

#[Route('/ordonnance')]
class OrdonnanceController extends AbstractController
{
    const PATH_PDF = "../pdf/";

    private $twig;
 private $snappy;

    public function __construct(Environment $twig,Pdf $snappy )
    {
        $this->twig = $twig;
        $this->snappy = $snappy;
    }
   
    #[Route('/', name: 'app_ordonnance_index', methods: ['GET'])]
    public function index(OrdonnanceRepository $ordonnanceRepository): Response
    {
        return $this->render('ordonnance/index.html.twig', [
            'ordonnances' => $ordonnanceRepository->findAll(),
        ]);
    }
    #[Route('/newjson', name: 'app_ordonnance_newjson')]
    public function newjson( OrdonnanceRepository $OrdonnanceRepository, NormalizerInterface $normalizer )
{
    $Ordonnances=$OrdonnanceRepository ->findAll();
    $OrdonnanceNprmalises = $normalizer ->normalize($Ordonnances, 'json ');
    $json =json_encode($OrdonnanceNprmalises);
    return new Response($json);
}
    #[Route('/new', name: 'app_ordonnance_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrdonnanceRepository $OrdonnanceRepository): Response
    {
        $Ordonnance = new Ordonnance();
        $form = $this->createForm(OrdonnanceType::class, $Ordonnance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $OrdonnanceRepository->save($Ordonnance, true);
            
            return $this->redirectToRoute('app_ordonnance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ordonnance/new.html.twig', [
            'Ordonnance' => $Ordonnance,
            'form' => $form,
        ]);
    }
   /*  #[Route('/new', name: 'pdf_generator', methods: ['GET', 'POST'])]
    public function new(Request $request, OrdonnanceRepository $entityManager): Response
    {
        $ordonnance = new Ordonnance();
        $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->save($ordonnance, true);
            //$entityManager->persist($ordonnance);
            //$entityManager->flush();
            return $this->redirectToRoute('app_ordonnance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ordonnance/pdf.html.twig', [
            'ordonnance' => $ordonnance,
            'form' => $form,
        ]);
    }
*/
    #[Route('/{id}', name: 'app_ordonnance_show', methods: ['GET'])]
    public function show(Ordonnance $ordonnance): Response
    {
        return $this->render('ordonnance/show.html.twig', [
            'ordonnance' => $ordonnance,
        ]);
    }
     
   #[Route('/imprimer/{id}', name:'app_ordonnance_imprimmaison')]
    public function imprimer(OrdonnanceRepository $OrdonnanceRepository, int $id): Response


   { 
    $ordonnance=$OrdonnanceRepository->find($id);
    $pdf = $this->getOrdonnancePdf($ordonnance);

    return new Response($pdf,200,array(
        'Content-Type' => 'application/pdf',
        'Content-disposition' => 'attachment; filename=page-ordonance.pdf'
    ));

    }
    public function getOrdonnancePdf(Ordonnance $ordonnance){
        $html = $this->twig->render(
            'ordonnance/pdf.html.twig',
            array(
                'ordonnance' => $ordonnance,
            )
        );
        $response = new PdfResponse(
            $this->snappy->getOutputFromHtml($html,array(
                'margin-top'    => 10,
                'margin-right'  => 10,
                'margin-bottom' => 10,
                'margin-left'   => 10,
                'footer-spacing' => -5,
                'footer-font-name' => 'Calibri',
            )),
            'Ordonnance.pdf'
        );

        return $response;


    }


    #[Route('/{id}/edit', name: 'app_ordonnance_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ordonnance $ordonnance, OrdonnanceRepository $ordonnanceRepository): Response
    {
        $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ordonnanceRepository->save($ordonnance, true);

            return $this->redirectToRoute('app_ordonnance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ordonnance/edit.html.twig', [
            'ordonnance' => $ordonnance,
            'form' => $form,
        ]);
    }
 
    #[Route('/{id}', name: 'app_ordonnance_delete', methods: ['POST'])]
    public function delete(Request $request, Ordonnance $ordonnance, OrdonnanceRepository $ordonnanceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ordonnance->getId(), $request->request->get('_token'))) {
            $ordonnanceRepository->remove($ordonnance, true);
        }

        return $this->redirectToRoute('app_ordonnance_index', [], Response::HTTP_SEE_OTHER);
    }
  
}

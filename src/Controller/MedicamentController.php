<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Entity\Medicament;
use App\Form\MedicamentType;
use App\Repository\MedicamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;

#[Route('/medicament')]
class MedicamentController extends AbstractController
{
    // logger
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function doStuff()
    {
        $this->logger->info('I love Tony Vairelles\' hairdresser.');
    }
    //---------------------
    #[Route('/', name: 'app_medicament_index', methods: ['GET'])]
    public function index(MedicamentRepository $medicamentRepository,CategorieRepository $categorieRepository): Response
    {
        return $this->render('medicament/index.html.twig', [
            'medicaments' => $medicamentRepository->findAll(),
            'categories' => $categorieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_medicament_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MedicamentRepository $entityManager,NotifierInterface $notifier): Response
    {
        $medicament = new Medicament();
        $form = $this->createForm(MedicamentType::class, $medicament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->getClientOriginalExtension();
                $imageFile->move(
                    $this->getParameter('app.photos_directory'),
                    $newFilename
                );
                $medicament->setImage($newFilename);
            }
            $entityManager->save($medicament, true);
            $notifier->send(new Notification('Can you check your submission? There are some problems with it.', ['browser']));
            return $this->redirectToRoute('app_medicament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medicament/new.html.twig', [
            'medicament' => $medicament,
            'form' => $form,
        ]);
    }
    #[Route('/search', name: 'medicament_search', methods: ['POST','GET'])]
    public function search(Request $request): JsonResponse
    {
        $query = $request->query->get('q');
        $this->logger->info($query);
        $medicaments = $this->getDoctrine()
            ->getRepository(Medicament::class)
            ->createQueryBuilder('m')
            ->where('m.nom LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->getQuery()
            ->getResult();

        $results = [];
        foreach ($medicaments as $medicament) {
            $results[] = [
                'nom' => $medicament->getNom()
            ];
        }
        return $this->json($results);
    }

    #[Route('/filtrer', name:'app_medicament_filtrer', methods: ['POST'])]
    public function filtrer(CategorieRepository $categorieRepository,Request $request){
            $this->logger->info("test");
            $selectedValue = $request->request->get('category');
            $this->logger->info($selectedValue);
            $medicament=$this->getDoctrine()
            ->getRepository(Medicament::class)
            ->createQueryBuilder('m')
            ->where('m.id_categorie = :query')
            ->setParameter('query', $selectedValue)
            ->getQuery()
            ->getResult();
            return $this->render('medicament/index.html.twig', [
                'medicaments' => $medicament,
                'categories' => $categorieRepository->findAll(),
            ]);
    }

    #[Route('/{id}', name: 'app_medicament_show', methods: ['GET'])]
    public function show(Medicament $medicament): Response
    {
        return $this->render('medicament/show.html.twig', [
            'medicament' => $medicament,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_medicament_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Medicament $medicament, MedicamentRepository $entityManager): Response
    {
        $form = $this->createForm(MedicamentType::class, $medicament);
        $form->handleRequest($request);         

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->save($medicament, true);

            return $this->redirectToRoute('app_medicament_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('medicament/edit.html.twig', [
            'medicament' => $medicament,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_medicament_delete', methods: ['POST'])]
    public function delete(Request $request, Medicament $medicament, MedicamentRepository $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medicament->getId(), $request->request->get('_token'))) {
            $entityManager->remove($medicament);
        }

        return $this->redirectToRoute('app_medicament_index', [], Response::HTTP_SEE_OTHER);
    }
    
    

}

<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class VehiculeController extends AbstractController
{
    #[Route('/ajax-search', name: 'app_vehicule_recherche')]
    public function chercher(Request $request,VehiculeRepository $entityManager): JsonResponse
    {
        $term = $request->query->get('searchValue');

        $queryBuilder = $entityManager->createQueryBuilder('v')
            ->select('v')
            ->where('v.immatriculation LIKE :term')
            ->setParameter('term', '%'.$term.'%');

        $vehicules = $queryBuilder->getQuery()->getResult();

        $response = [];
        foreach ($vehicules as $vehicule) {
            $response[] = [
                'type' => $vehicule->getTypeVehicule()->getNom(),
                'agence' => $vehicule->getTypeVehicule()->getAgence()->getNomag(),

                'immatriculation' => $vehicule->getImmatriculation(),
                'marque' => $vehicule->getMarque(),
                'puissance' => $vehicule->getPuissance(),
                'nbrdeplace' => $vehicule->getNbrdeplace(),
                'prix' => $vehicule->getPrix(),
            ];
        }

        return $this->json($response);
    }
    // #[Route('/', name: 'app_c_vehicule_index', methods: ['GET'])]
    // public function client(VehiculeRepository $vehiculeRepository): Response
    // {
    //     return $this->render('vehiculeclient/index.html.twig', [
    //         'vehicules' => $vehiculeRepository->findAll(),
    //     ]);
    // }
    #[Route('/')]
    public function redirectToLogin(){
        return $this->redirect('/login');
    }


    #[Route('/vehicule', name: 'app_vehicule_index', methods: ['GET'])]
    public function index(VehiculeRepository $vehiculeRepository): Response
    {
        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehiculeRepository->findAll(),
        ]);
    }


    #[Route('/vehicule/new', name: 'app_vehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VehiculeRepository $vehiculeRepository): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehiculeRepository->save($vehicule, true);

            return $this->redirectToRoute('app_typevehicule_show', [
                'id' => $vehicule->getTypeVehicule()->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vehicule/new.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/vehicule/{immatriculation}', name: 'app_vehicule_show', methods: ['GET'])]
    public function show(Vehicule $vehicule): Response
    {
        return $this->render('vehicule/show.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }

    #[Route('/{immatriculation}', name: 'app_vehiculeclient_show', methods: ['GET'])]
    public function showclient(Vehicule $vehicule): Response
    {
        return $this->render('vehiculeclient/showclient.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }

    #[Route('/vehicule/{immatriculation}/edit', name: 'app_vehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vehicule $vehicule, VehiculeRepository $vehiculeRepository): Response
    {
        $form = $this->createForm(VehiculeType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehiculeRepository->save($vehicule, true);

            return $this->redirectToRoute('app_typevehicule_show', [
                'id' => $vehicule->getTypeVehicule()->getId()
            ], Response::HTTP_SEE_OTHER);        }

        return $this->renderForm('vehicule/edit.html.twig', [
            'vehicule' => $vehicule,
            'form' => $form,
        ]);
    }

    #[Route('/vehicule/{immatriculation}', name: 'app_vehicule_delete', methods: ['POST'])]
    public function delete(Request $request, Vehicule $vehicule, VehiculeRepository $vehiculeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicule->getImmatriculation(), $request->request->get('_token'))) {
            $vehiculeRepository->remove($vehicule, true);
        }

        return $this->redirectToRoute('app_vehicule_index', [], Response::HTTP_SEE_OTHER);
    }




}

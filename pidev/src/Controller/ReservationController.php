<?php

namespace App\Controller;

use App\Entity\Vehicule;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Entity\Reservation;
use App\Entity\Agence;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(): Response
    {

        return $this->render('reservation/client_index.html.twig', [
            'reservations' => $this->getUser()->getReservations(),
        ]);
    }
    #[Route('/newreservation', name: 'newreservation', methods: ['GET', 'POST'])]
    public function newreservation(Request $request,EntityManagerInterface $em): Response
    {
        $type = new Reservation();
        $form = $this->createForm(ReservationType::class, $type);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($type);
            $em->flush();
            return $this->redirectToRoute('AfficheReservation');
        }
        return $this->render('reservation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/reserver/{immatriculation}', name: 'newres', methods: ['GET', 'POST'])]
    public function clientreservation(Vehicule $vehicule ,Request $request,EntityManagerInterface $em): Response
    {
        $type = new Reservation();
        $form = $this->createForm(ReservationType::class, $type);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $type->setUser($this->getUser());
            $type->setVehicule($vehicule);
            $em->persist($type);
            $em->flush();
            return $this->redirectToRoute('app_reservation');
        }
        return $this->render('reservation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/AfficheReservation', name: 'AfficheReservation' ,methods: ['GET'])]
    public function AfficheReservation(ReservationRepository $repository): Response
    {
        $type = $repository->findAll();

        return $this->render('reservation/show.html.twig', [
            'aa' => $type,
        ]);
    }
    #[Route('/search', name: 'search')]
public function search(Request $request, ReservationRepository $repository)
{
    // Get the search query from the request parameters
    $nom = $request->query->get('nom');

    // Query the database for reservations that match the search query
    $qb = $repository->createQueryBuilder('r');
    $qb->where($qb->expr()->like('LOWER(r.NomLoc)', ':nom'))
        ->setParameter('nom', '%' . strtolower($nom) . '%');
    $reservations = $qb->getQuery()->getResult();

    // Transform the reservations into a format suitable for the AJAX response
    $results = array_map(function (Reservation $reservation) {
        return [
            'id' => $reservation->getId(),
            'date' => $reservation->getDateRes() ? $reservation->getDateRes()->format('Y-m-d') : '',
            'heure' => $reservation->getHeureRes() ? $reservation->getHeureRes()->format('H:i:s') : '',
            'methode' => $reservation->getMethodP(),
            'duree' => $reservation->getDureeLoc(),
            'nom' => $reservation->getNomLoc(),
            'cin' => $reservation->getCinLoc(),
            'deleteUrl' => $this->generateUrl('deleteReservation', ['id' => $reservation->getId()]),
            'editUrl' => $this->generateUrl('editR', ['id' => $reservation->getId()]),
        ];
    }, $reservations);

    // Return the search results as a JSON response
    return new JsonResponse($results);
}

    #[Route('/deleteReservation/{id}', name: 'deleteReservation')]
    public function deleteReservation(Request $request, Reservation $reservation): Response
    {         $em = $this->getDoctrine()->getManager();

        $response = $em->getRepository(Agence::class)->findOneBy(['reservation' => $reservation]);
    
        if ($response) {
            // Affichage d'un message d'erreur en pop-up
            $this->addFlash('error', 'L agence associée à cette reservation doit être supprimée avant de pouvoir supprimer la reservation elle-même.');
        } else {
            // Suppression de la réclamation
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
            $this->addFlash('success', 'La reservation a été supprimée avec succès.');
        }
        return $this->redirectToRoute('AfficheReservation');
    }
    #[Route('editReservation/{id}', name: 'editR', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $Reservation, ReservationRepository $ReservationRepository): Response
    {
        $form = $this->createForm(ReservationType::class, $Reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ReservationRepository->save($Reservation, true);

            return $this->redirectToRoute('AfficheReservation', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}



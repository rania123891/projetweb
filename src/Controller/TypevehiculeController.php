<?php

namespace App\Controller;

use App\Entity\Typevehicule;
use App\Form\TypevehiculeType;
use App\Repository\TypevehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/typevehicule')]
class TypevehiculeController extends AbstractController
{
    #[Route('/', name: 'app_typevehicule_index', methods: ['GET'])]
    public function index(TypevehiculeRepository $typevehiculeRepository,Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $typevehiculeRepository->findAll(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('typevehicule/index.html.twig', [
            'pagination' => $pagination,
        ]);

    }

    #[Route('/new', name: 'app_typevehicule_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TypevehiculeRepository $typevehiculeRepository): Response
    {
        $typevehicule = new Typevehicule();
        $form = $this->createForm(TypevehiculeType::class, $typevehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typevehiculeRepository->save($typevehicule, true);

            return $this->redirectToRoute('app_typevehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('typevehicule/new.html.twig', [
            'typevehicule' => $typevehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_typevehicule_show', methods: ['GET'])]
    public function show(Typevehicule $typevehicule): Response
    {
        return $this->render('typevehicule/show.html.twig', [
            'typevehicule' => $typevehicule,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_typevehicule_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Typevehicule $typevehicule, TypevehiculeRepository $typevehiculeRepository): Response
    {
        $form = $this->createForm(TypevehiculeType::class, $typevehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $typevehiculeRepository->save($typevehicule, true);

            return $this->redirectToRoute('app_typevehicule_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('typevehicule/edit.html.twig', [
            'typevehicule' => $typevehicule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_typevehicule_delete', methods: ['POST'])]
    public function delete(Request $request, Typevehicule $typevehicule, TypevehiculeRepository $typevehiculeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typevehicule->getId(), $request->request->get('_token'))) {
            $typevehiculeRepository->remove($typevehicule, true);
        }

        return $this->redirectToRoute('app_typevehicule_index', [], Response::HTTP_SEE_OTHER);
    }
}

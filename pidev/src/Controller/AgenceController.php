<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AgenceType;
use App\Repository\AgenceRepository;
use App\Entity\Agence;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Knp\Component\Pager\PaginatorInterface;
use TCPDF;

class AgenceController extends AbstractController
{
    #[Route('/agence', name: 'app_agence')]
    public function index(): Response
    {
        return $this->render('agence/index.html.twig', [
            'controller_name' => 'AgenceController',
        ]);
    }
    #[Route('/newagence', name: 'newagence', methods: ['GET', 'POST'])]
    public function newagence(Request $request,MailerInterface $mailer): Response
    {
        $type = new Agence();
        $form = $this->createForm(AgenceType::class, $type);
        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $type = $form->getData();
            $type->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();
            // $email = (new Email())
            // ->from('yassine.benjaber@esprit.tn')
            // ->to($type->getEmailAg())
            // ->subject('Agence')
            // ->text('Une Nouvelle Agence a été ajouté a vous.');
            // try{
            //     $mailer->send($email);
            // }catch(\Throwable $th ){
            //     dd($th);
            // }
            return $this->redirectToRoute('AfficheAgence');
        }
        return $this->render('agence/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'] )]
    public function edit(Request $request, Agence $agence, AgenceRepository $agenceRepository): Response
    {
        $form = $this->createForm(AgenceType::class, $agence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $agenceRepository->save($agence, true);

            return $this->redirectToRoute('AfficheAgence', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('agence/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    // #[Route('/AfficheAgence', name: 'AfficheAgence' ,methods: ['GET'])]
    // public function AfficheAgence(AgenceRepository $repository): Response
    // {
    //     $type = $repository->findAll();

    //     return $this->render('agence/show.html.twig', [
    //         'aa' => $type,
    //     ]);
    // }
    #[Route('/AfficheAgence', name: 'AfficheAgence' ,methods: ['GET'])] //Paginator
public function AfficheAgence(Request $request, AgenceRepository $repository,PaginatorInterface $paginator): Response
{
    if($this->isGranted('ROLE_ADMIN')){
    $type = $repository->findAll();
    }
    else {
        $type = $this->getUser()->getAgences();
    }

    $pagination = $paginator->paginate(
        $type,
        $request->query->getInt('page', 1),
        10
    );

    return $this->render('agence/show.html.twig', [
        'pagination' => $pagination,
    ]);
}
#[Route('/agence/{id}/pdf', name: 'app_generate_agence_pdf')] //PDF
public function generatePdf(Request $request, Agence $agence): Response
{
    $html = $this->renderView('agence/pdf.html.twig', [
        'agence' => $agence,
    ]);

    $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();

    $pdf->writeHTML($html, true, false, true, false, '');

    $pdfContent = $pdf->Output('agence.pdf', 'S');

    return new Response($pdfContent, 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="agence.pdf"'
    ]);
}
    #[Route('/AfficheAgenceFront', name: 'AfficheAgenceFront' ,methods: ['GET'])]
    public function AfficheAgenceFront(AgenceRepository $repository): Response
    {
        $type = $repository->findAll();

        return $this->render('agence/showfront.html.twig', [
            'aa' => $type,
        ]);
    }
    #[Route('/searchin', name: 'search__')]
public function search(Request $request, AgenceRepository $repository)
{
  // Get the search query from the request parameters
  $query = $request->request->get('query');

  // Query the database for agencies that match the search query
  $agences = $repository->createQueryBuilder('a')
      ->where('LOWER(a.RefAg) LIKE :query')
      ->setParameter('query', '%'.strtolower($query).'%')
      ->getQuery()
      ->getResult();

  // Transform the agencies into a format suitable for the AJAX response
  $results = array_map(function (Agence $agence) {
    return [
      'id' => $agence->getId(),
      'username' => $agence->getUser()->getNom(),
      'NomAg' => $agence->getNomAg(),
      'NombreAg' => $agence->getNombreAg(),
      'RefAg' => $agence->getRefAg(),
      'EmailAg' => $agence->getEmailAg(),
      'AdresseAg' => $agence->getAdresseAg(),
      'VilleAg' => $agence->getVilleAg(),
    ];
  }, $agences);

  // Return the results as a JSON response
  return new JsonResponse($results);
}

    #[Route('/deleteAgence/{id}', name: 'deleteAgence')]
    public function deleteAgence($id)
    {
        $em=$this->getDoctrine()->getManager();
        $type= $em ->getRepository (Agence::class)->find ($id);
        $em->remove($type);
        $em->flush();

        return $this->redirectToRoute('AfficheAgence');
    }
    #[Route('/details/{id}', name:'agence_details')]
    public function details(Agence $agence){
        return $this->render('agence/details.html.twig',[
            'agence'=>$agence,
        ]);
    }
  
    
    /*public function generatePdfAction()
    {
        // Create a new instance of the Pdf class
        $snappy = new Pdf('C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf');
    
        // Generate the PDF file from the HTML content of the page
        $html = $this->renderView('agence/show.html.twig');
        $pdf = $snappy->generateFromHtml($html);
    
        // Return the PDF file as a response
        return new Response($pdf, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="file.pdf"',
            'aa' => $type,
        ]);
    }
    */
}

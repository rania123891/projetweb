<?php

namespace App\Controller;
use App\Repository\PublicationRepository;
use Dompdf\Dompdf;
use App\Entity\User;
use App\Form\User1Type;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/users/', name: 'app_user_index', methods: ['GET'])]
public function index(UserRepository $userRepository, Request $request, PaginatorInterface $paginator): Response
{
    $page = $request->query->getInt('page', 1); // Get the current page from the query string

    $query = $userRepository->createQueryBuilder('u')
        ->orderBy('u.id', 'DESC')
        ->getQuery();

    $users = $paginator->paginate(
        
        $query, // The query to paginate
        $page, // The current page
        5// The number of items per page
    );

    // Render the template with the paginated list of users
    return $this->render('user/index.html.twig', [
        'users' => $users,
        'page' => $page,
    ]);
}

    #[Route('/users/front', name: 'front', methods: ['GET'])]
    public function front(UserRepository $userRepository): Response
    {
        return $this->render('baseFront.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/users/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/users/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getFile() != null){
                $user->getUploadFile();
            }
             $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_edit', array('id' => $user->getId()), Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/users/delete/{id}', name: 'delete')]
    public function delete($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $res = $em->getRepository(User::class)->find($id);
        $em->remove($res);
        $em->flush();
        return $this->redirectToRoute('app_user_index');
    }

   /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/pdf",name="pdf")
     */

     public function makepdf()
     {
         $pdfOptions = new Options();
         $Resteau=new \App\Entity\User();
         $pdfOptions->set('defaultFont', 'Arial');
 
         // Instantiate Dompdf with our options
         $dompdf = new Dompdf();
         $user = $this->getDoctrine()->getRepository(\App\Entity\User::class)->findAll();
 
         // Retrieve the HTML generated in our twig file
         $html = $this->renderView('user/index.html.twig',['users'=>$user]
         );
 
         // Load HTML to Dompdf
         $dompdf->loadHtml($html);
 
         // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
         $dompdf->setPaper('A4', 'portrait');
 
         // Render the HTML as PDF
         $dompdf->render();
 
         // Output the generated PDF to Browser (force download)
         $dompdf->stream("mypdf.pdf", [
             "Attachment" => true
         ]);
         return $this->redirectToRoute("app_user_index");
 
 
 
 
     }

    #[Route("/users/pdfuser/{id}",name:"pdfuser", methods: ['GET'])]
    public function pdf($id,UserRepository $repository): Response{
        $credit=$repository->find($id);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('user/pdf.html.twig', [
            'pdf' => $credit,

        ]);
        $dompdf->loadHtml($html);
        //  $dompdf->loadHtml('<h1>Hello, World!</h1>');

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        //  $dompdf->stream();
        // Output the generated PDF to Browser (force download)
        /* $dompdf->stream($reclamation->getType(), [
             "Attachment" => false
         ]);*/
        $pdfOutput = $dompdf->output();
        return new Response($pdfOutput, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="user.pdf"'
        ]);

    }


    #[Route("/users/statt",name:"statt")]

    public function statAction(UserRepository $test)
    {


        $users= $test->findAll();

        foreach($users as $i){
            $coursnom[]=$i->getNom();
            $coursprix[]=sizeof($i->getRoles());

        }

        return $this->render('user/stat.html.twig',
            [

                'coursnom'=> json_encode($coursnom),
                'coursprix'=> json_encode($coursprix),


            ]);


    }

/**
 * @Route("/users/forgot-password", name="user_forgot_password", methods={"GET","POST"})
 */
public function forgotPassword(Request $request, UserRepository $userRepository, MailerInterface $mailer, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
{
    if ($request->isMethod('POST')) {
        $email = $request->request->get('email');

        $user = $userRepository->findOneBy(['email' => $email]);

        if ($user) {
            // Génération d'un nouveau mot de passe aléatoire
            $newPassword = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 10);

            // Envoi de l'e-mail contenant le nouveau mot de passe
            $email = (new Email())
                ->from('ounihamdi4@gmail.com')
                ->to($user->getEmail())
                ->subject('Nouveau mot de passe')
                ->html(
                    $this->renderView(
                        'user/forgot_password_email.html.twig',
                        ['newPassword' => $newPassword]
                    )
                );

            $mailer->send($email);

            // Modification du mot de passe dans la base de données
            $user->setPassword($newPassword);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Un e-mail contenant votre nouveau mot de passe a été envoyé à l\'adresse ' . $user->getEmail());

            return $this->redirectToRoute('app_login');
        } else {
            $this->addFlash('error', 'L\'adresse e-mail que vous avez saisie ne correspond à aucun compte.');
        }
    }

    return $this->render('user/forgot_password.html.twig');
}
}

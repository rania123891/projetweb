<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Twilio\Rest\Client;

class SendSMSController extends AbstractController
{
    /**
     * @Route("/send-sms", name="send_sms")
     */
    public function sendSMS(Request $request): Response
    {
        if ($request->isMethod('post')) {
            // Récupérer le numéro de téléphone et le message à envoyer depuis le formulaire
            $phoneNumber = "+216".$request->request->get('numberField');
            $message = $request->request->get('messageField');

            // Initialiser l'objet Client Twilio avec votre SID de compte et votre token d'authentification
            $client = new Client('AC0f319b41631d9977d8624e835988aa65', '9f8e011d479a8363026950bb47316faa');

            // Envoyer le message SMS en utilisant la méthode 'create' de l'objet Message
            $sms = $client->messages->create(
                // Le numéro de téléphone de destination au format E.164
                $phoneNumber,
                array(
                    // Le numéro de téléphone de l'expéditeur au format E.164
                    'from' => '+12762861931',
                    // Le corps du message
                    'body' => $message
                )
            );

            // Afficher le SID du message envoyé pour le débogage
            echo $sms->sid;

            // Rediriger l'utilisateur vers la page d'accueil
            return $this->redirectToRoute('app_login');
        }

        // Afficher la vue du formulaire
        return $this->render('send_sms/index.html.twig');
    }
}

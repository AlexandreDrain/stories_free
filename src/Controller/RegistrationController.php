<?php
namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_user_registration")
     */
    public function register(Request $request)
    {
        // Création du formulaire basé sur la classe UsersType
        $user = new Users();
        $form = $this->createForm(UsersType::class, $user);

        // Récupère les données de la requête POST
        $form->handleRequest($request);
        // Les vérifications classiques de Symfony avec les formulaires.
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            // Sauvegarde de l'utilisateur/la requête.
            $entityManager->persist($user);
            // Envoi de l'utilisateur fraichement crée dans la bdd.
            $entityManager->flush();

            // Redirection vers la connection
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
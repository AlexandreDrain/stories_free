<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use App\Notifier\CustomLoginLinkNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\LoginLink\LoginLinkHandlerInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login_check", name="app_login_check")
     */
    public function check()
    {
        throw new \LogicException('This code should never be reached');
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(NotifierInterface $notifier, AuthenticationUtils $authenticationUtils, LoginLinkHandlerInterface $loginLinkHandler, UsersRepository $usersRepository, Request $request): Response
    {
        // check if login form is submitted
        if ($request->isMethod('POST')) {
            // load the user in some way (e.g. using the form input)
            $email = $request->request->get('email');
            $user = $usersRepository->findOneBy(['email' => $email]);

            if ($user === null){
                $this->addFlash('danger', 'Cet email n\'existe pas, veuillez d\'abord vous inscrire =D');
                return $this->redirectToRoute('app_login');;
            }

            // create a login link for $user this returns an instance
            // of LoginLinkDetails
            $loginLinkDetails = $loginLinkHandler->createLoginLink($user);
            // create a notification based on the login link details
            $notification = new CustomLoginLinkNotification(
                $loginLinkDetails,
                'Bienvenue sur mon site!' // email subject
            );
            // create a recipient for this user
            $recipient = new Recipient($user->getEmail());

            // send the notification to the user
            $notifier->send($notification, $recipient);

            // render a "Login link is sent!" page
            return $this->render('security/login_link_sent.html.twig');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

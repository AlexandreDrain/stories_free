<?php

namespace App\Controller;

use App\Repository\StoriesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(StoriesRepository $storiesRepository): Response
    {
        // Rends la vu avec en paramètre le retour de findBest, qui va récupérer dans la base de donnée les dix premières stories selon les like.
        return $this->render('home/index.html.twig', [
            "stories" => $storiesRepository->findBest()
        ]);
    }
}

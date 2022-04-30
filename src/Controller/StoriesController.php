<?php

namespace App\Controller;

use App\Entity\Stories;
use App\Form\StoriesType;
use App\Repository\TagsRepository;
use App\Repository\StoriesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StoriesController extends AbstractController
{
    /**
     * @Route("/stories", name="app_stories")
     */
    public function index(StoriesRepository $storiesRepository): Response
    {
        // Rends la vu avec en paramètre toutes les stories.
        return $this->render('stories/index.html.twig', [
            "stories" => $storiesRepository->findAll()
        ]);
    }

    /**
     * @Route("/ajouter_une_histoire", name="app_add_story")
     */
    public function add(Request $request, TagsRepository $tagsRepository): Response
    {
        // Création du formulaire basé sur la classe StoriesUser
        $user = new Stories();
        $form = $this->createForm(StoriesType::class, $user);

        return $this->render('stories/add.html.twig',[
            'form' => $form->createView(),
            'tags' => $tagsRepository->findAll()
        ]);
    }
}

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
     * @Route("/histoires", name="app_stories")
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
        // Création du formulaire basé sur la classe Stories
        $story = new Stories();
        $form = $this->createForm(StoriesType::class, $story);

        return $this->render('stories/add.html.twig',[
            'form' => $form->createView(),
            'tags' => $tagsRepository->findAll()
        ]);
    }

    /**
     * @Route("/histoire/{id}", name="app_story")
     */
    public function show(Stories $story): Response
    {
        return $this->render('stories/show.html.twig',[
            'story' => $story,
        ]);
    }
}

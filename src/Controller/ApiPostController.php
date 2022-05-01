<?php

namespace App\Controller;

use App\Entity\Stories;
use App\Repository\UsersRepository;
use App\Repository\StoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

/**
 * Deux méthodes, index permet de récupérer toutes les 'stories'
 */
class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/stories", name="app_api_stories", methods={"GET"})
     */
    public function index(StoriesRepository $storiesRepository): JsonResponse
    {
        /*
            Retour json, cette méthode va serialiser les données retournées par findAll,
            en prenant en compte différents paramètres, comme le status de la requête, ou encore les propriétés de l'entité à sérialiser.
         */
        return $this->json($storiesRepository->findAll(), 200, [], ['groups' => 'post:read']);

    }

    /**
     * @Route("/api/create/storie", name="app_api_storie_create", methods={"POST"})
     */
    public function newStorie(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, UsersRepository $usersRepository)
    {
        $user = $this->getUser();
        if ($user) {
            try {
                $json = $request->getContent();
                // $jsonObject = json_decode($json);

                $story = $serializer->deserialize($json, Stories::class, 'json');

                $story->setLiked(0);
                $story->setDisliked(0);
                $story->setCreatedAt(new \DateTimeImmutable("NOW"));
                $story->setUser($user);

                $entityManager->persist($story);
                $entityManager->flush();

                /*
                    Retour json, cette méthode va serialiser les données retournées par findAll,
                    en prenant en compte différents paramètres, comme le status de la requête, ou encore les propriétés de l'entité à sérialiser.
                 */
                return $this->json($story, 201, [], ['groups' => 'post:read']);
            } catch (NotEncodableValueException $e) {
                return $this->json([
                    "satus" => 400,
                    'success' => false,
                    "message" => "Syntax error"
                ]);
            }
        } else {
            // Retourne une JsonResponse dans le cas où l'utilisateur n'est pas connecté
            return $this->json(['success' => false, 'message' => "Vous devez vous connecter pour pouvoir ajouter une histoire"], 400);
        }
    }
}

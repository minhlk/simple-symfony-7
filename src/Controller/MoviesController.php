<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    #[Route('/movies/{name}', methods: ['GET'], name: 'app_movies')]
    public function index(): Response
    {
        $movies = ['Doremon', 'Tom&Jerry', 'Pink Panther'];
        return $this->render('index.html.twig', [
            'movies' => $movies
        ]);
    }
}

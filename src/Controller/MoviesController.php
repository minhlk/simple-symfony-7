<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieFormType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    private $movieRepository;
    private $em;
    public function __construct(MovieRepository $movieRepository, EntityManagerInterface $em)
    {
        $this->movieRepository = $movieRepository;
        $this->em = $em;
    }

    #[Route('/movies', methods: ['GET'], name: 'app_movies')]
    public function index(): Response
    {
        $movies = $this->movieRepository->findAll();

        return $this->render('movies/index.html.twig', [
            'movies' => $movies
        ]);
    }

    #[Route('/movies/{id}', methods: ['GET'], name: 'app_movies_detail')]
    public function show($id): Response
    {
        $movie = $this->movieRepository->find(['id' => $id]);

        return $this->render('movies/show.html.twig', [
            'movie' => $movie
        ]);
    }

    #[Route('/movie/create', methods: ['GET', 'POST'], name: 'app_movies_create')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(MovieFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newMovie = $form->getData();
            $imagePath = $form->get('imagePath')->getData();
            if ($imagePath) {
                $newFileName = uniqid() . '.' . $imagePath->guessExtension();
                try {
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $newMovie->setImagePath('/uploads/' . $newFileName);
            }
            $this->em->persist($newMovie);
            $this->em->flush();
            return $this->redirectToRoute('app_movies');
        }
        
        return $this->render('movies/create.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/movie/edit/{id}', methods: ['GET', 'POST'], name: 'app_movies_edit')]
    public function edit(Request $request, $id): Response
    {
        $movie = $this->movieRepository->find($id);
        $form = $this->createForm(MovieFormType::class, $movie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newMovie = $form->getData();
            $imagePath = $form->get('imagePath')->getData();
            if ($imagePath) {
                $newFileName = uniqid() . '.' . $imagePath->guessExtension();
                try {
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads',
                        $newFileName
                    );
                } catch (FileException $e) {
                    return new Response($e->getMessage());
                }
                $newMovie->setImagePath('/uploads/' . $newFileName);
            }
            
            $this->em->persist($newMovie);
            $this->em->flush();
            return $this->redirectToRoute('app_movies');
        }
        
        return $this->render('movies/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/movie/delete/{id}', methods: ['GET', 'DELETE'], name: 'app_movies_delete')]
    public function delete($id): Response
    {
        $movie = $this->movieRepository->find($id);
        $this->em->remove($movie);
        $this->em->flush();
        return $this->redirectToRoute('app_movies');
    }
}

<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtworksController extends AbstractController
{
    /**
     * @Route("/artworks", name="artworks")
     */
    public function index(PostsRepository $postsRepository): Response
    {
        $publishedPosts = $postsRepository->findPublishedPosts();
        return $this->render('artworks/index.html.twig', [
            'publishedPosts' => $publishedPosts,
        ]);

    }
}

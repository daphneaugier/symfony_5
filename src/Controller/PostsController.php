<?php

namespace App\Controller;

use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{
    /**
     * @Route("/", name="posts")
     */

    public function index(PostsRepository $postsRepository): Response
    {
        // $posts = $postsRepository->findAll();
        // dd($posts);

        $lastPosts = $postsRepository->findLastPosts(6);
        return $this->render('posts/index.html.twig', [
            'lastPosts' => $lastPosts,
        ]);
    }
}

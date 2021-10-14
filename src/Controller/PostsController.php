<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Repository\PostsRepository;
use Doctrine\ORM\Mapping\Driver\RepeatableAttributeCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController  extends AbstractController
{

    /**
     * @Route("/", name="posts")
     */
    public function index(PostsRepository $postsRepository): Response
        {

            $lastPosts = $postsRepository->findLastPosts(6);
            return $this->render('posts/index.html.twig', [
                'lastPosts' => $lastPosts,
            ]);

    }

    /**
     * Display of selected post
     * @Route("/posts/{id}", name="posts_read")
     *
     * @return void
     */
    public function read(Posts $posts): Response
    {
        return $this->render('posts/read.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('posts/about.html.twig');
    }

}

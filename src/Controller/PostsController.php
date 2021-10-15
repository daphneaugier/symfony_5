<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Entity\Posts;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\PostsRepository;
use Doctrine\ORM\Mapping\Driver\RepeatableAttributeCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function read(Posts $Posts, Request $request): Response
    {
        if($this->getUser() == null){
            return $this->render('posts/read.html.twig', [
                'posts' => $Posts,
            ]);

        }else{
            $comment = new Comment;
            $comment->setAuthorName($this->getUser()->getFirstName()." ".$this->getUser()->getLastName());
            $comment->setPosts($Posts);

            $form = $this->createForm(CommentType::class, $comment);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $comment = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($comment);
                $entityManager->flush();
            }

            return $this->renderForm('posts/read.html.twig', [
                'posts' => $Posts,
                'form' => $form,
            ]);
        }
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('posts/about.html.twig');
    }

}
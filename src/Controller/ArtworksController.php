<?php

namespace App\Controller;

use App\Form\ArtworkType;
use App\Entity\Posts;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/submit", name="submit")
     */
    public function add(Request $request): Response
    {
        if($this->getUser() == null){
            return $this->redirectToRoute('posts');
        }else{
            $new_post = new Posts();
            $new_post->setUser($this->getUser());
            $new_post->setCreatedAt(new \DateTime());
            $new_post->setUpdatedAt(new \DateTime());

            $form = $this->createForm(ArtworkType::class, $new_post);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $image_file = $form->get('image_file')->getData();

                if ($image_file) {
                    $originalFilename = pathinfo($image_file->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$image_file->guessExtension();

                    // Move the file to the directory where images are stored
                    try {
                        $image_file->move(
                            $this->getParameter('images_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        echo "Image : $image_file error $e";
                        die();
                    }

                    // updates the 'image_filename' property to store the image file name
                    // instead of its contents
                    $new_post->setImage($newFilename);

                    $new_post = $form->getData();

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($new_post);
                    $entityManager->flush();

                    return $this->redirectToRoute('posts');
                }
            }

            return $this->renderForm('artworks/submit.html.twig', [
                'form' => $form,
            ]);
        }
    }
}
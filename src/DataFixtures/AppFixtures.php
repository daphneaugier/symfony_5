<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Posts;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $generator = Faker\Factory::create("fr_FR");

        for($i = 0 ; $i < 20 ; $i++) {
            $user = new User();
            $password = $this->encoder->encodePassword($user , 'password');

            $user
                ->setFirstName($generator->firstName)
                ->setLastName($generator->lastName)
                ->setUsername($generator->userName)
                ->setPassword($password);
            $manager->persist($user);

            for($j = 0 ; $j < rand(10,15); $j++) {
                $posts = new Posts();
                $posts
                    ->setTitle($generator->word)
                    ->setContent($generator->word)
                    ->setStatus(
                        $generator->randomElement(['DRAFT' , 'PUBLISHED' , 'DELETED'])
                    )
                    ->setCreatedAt($generator->dateTimeBetween('-1 year', 'now'))
                    ->setUser($user);
                $manager->persist($posts);

                for($k = 0 ; $k < rand(1,5); $k++) {
                    $comment = new Comment();
                    $comment
                        ->setCommentText($generator->word)
                        ->setPosts($posts);
                    $manager->persist($comment);
                }
            }
        }
        $manager->flush();
    }
}

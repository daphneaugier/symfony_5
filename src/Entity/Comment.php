<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $comment�_text;

    /**
     * @ORM\ManyToOne(targetEntity=Posts::class, inversedBy="comments")
     */
    private $Posts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment�Text(): ?string
    {
        return $this->comment�_text;
    }

    public function setComment�Text(string $comment�_text): self
    {
        $this->comment�_text = $comment�_text;

        return $this;
    }

    public function getPosts(): ?Posts
    {
        return $this->Posts;
    }

    public function setPosts(?Posts $Posts): self
    {
        $this->Posts = $Posts;

        return $this;
    }
}

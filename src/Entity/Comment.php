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
    private $commentÂ_text;

    /**
     * @ORM\ManyToOne(targetEntity=Posts::class, inversedBy="comments")
     */
    private $Posts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentÂText(): ?string
    {
        return $this->commentÂ_text;
    }

    public function setCommentÂText(string $commentÂ_text): self
    {
        $this->commentÂ_text = $commentÂ_text;

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

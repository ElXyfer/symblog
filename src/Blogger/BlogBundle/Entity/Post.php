<?php

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Post
 *
 * @ORM\Table(name="posts")
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Repository\PostRepository")
 * @ExclusionPolicy("all")
 */
class Post
{
    /**
     * @ORM\ManyToOne(targetEntity="Blogger\BlogBundle\Entity\User", inversedBy="posts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Blogger\BlogBundle\Entity\Book", inversedBy="posts")
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $book;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Expose
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     * @Expose
     */
    private $content;

    /**
     *
     * @ORM\Column(name="published", type="datetime")
     * @Expose
     */

    private $published;


    /**
     *
     * @var boolean
     *
     * @ORM\Column(name="likeRating", type="boolean")
     * @Expose
     */

    private $like;

    /**
     * @return bool
     */
    public function isLike()
    {
        return $this->like;
    }

    /**
     * @param bool $like
     *
     * @return Post
     */
    public function setLike($like)
    {
        $this->like = $like;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /*
     * Set published
     *
     * @return Post
     */
    public function  setPublished($published)
    {
         $this->published = $published;
         return $this;
    }

    /**
     * Get published
     *
     * @return \DateTime
     */
    public function getPublished()
    {
        return$this->published;
    }

    /**
     * Set content
     *
     * @param string $user
     *
     * @return Post
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set content
     *
     * @param string $book
     *
     * @return Post
     */
    public function setBook($book)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return string
     */
    public function getBook()
    {
        return $this->book;
    }



}


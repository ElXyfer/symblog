<?php

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="ws_user")
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Repository\UserRepository")
 */
class User extends  BaseUser
{

    /**
     * @ORM\OneToMany(targetEntity="Blogger\BlogBundle\Entity\Post", mappedBy="user")
     */
    private $posts;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @ORM\OneToMany(targetEntity="Blogger\BlogBundle\Entity\Book", mappedBy="submittedBy")
     */
    private $books;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->books = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add post
     *
     * @param \Blogger\BlogBundle\Entity\Post $post
     *
     * @return User
     */
    public function addPost(\Blogger\BlogBundle\Entity\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \Blogger\BlogBundle\Entity\Post $post
     */
    public function removePost(\Blogger\BlogBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Add book
     *
     * @param \Blogger\BlogBundle\Entity\Book $book
     *
     * @return User
     */
    public function addBook(\Blogger\BlogBundle\Entity\Book $book)
    {
        $this->books[] = $book;

        return $this;
    }

    /**
     * Remove book
     *
     * @param \Blogger\BlogBundle\Entity\Book $book
     */
    public function removeBook(\Blogger\BlogBundle\Entity\Book $book)
    {
        $this->books->removeElement($book);
    }

    /**
     * Get books
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBooks()
    {
        return $this->books;
    }
}

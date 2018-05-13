<?php

namespace Blogger\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Book
 *
 * @ORM\Table(name="books")
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Repository\BookRepository")
 * @ExclusionPolicy("all")
 */
class Book
{

    /**
     * @ORM\OneToMany(targetEntity="Blogger\BlogBundle\Entity\Post", mappedBy="book")
     */
    private $posts;

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
     * @var \Blogger\BlogBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="Blogger\BlogBundle\Entity\User", inversedBy="books")
     * @ORM\JoinColumn(name="submitted_by", referencedColumnName="id")
     */
    private $submittedBy;

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
     * @ORM\Column(name="book_author", type="string", length=255)
     * @Expose
     */
    private $bookAuthor;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     * @Expose
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     * @Expose
     */
    private $picture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="year_published", type="string", nullable=true)
     * @Expose
     */
    private $yearPublished;

    /**
     *
     * @ORM\Column(name="time_stamp", type="datetime")
     * @Expose
     */

    private $timeStamp;

    /**
     * Book constructor.
     * @param $posts
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
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
     * @return Book
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
     * Set bookAuthor
     *
     * @param string $bookAuthor
     *
     * @return Book
     */
    public function setBookAuthor($bookAuthor)
    {
        $this->bookAuthor = $bookAuthor;

        return $this;
    }

    /**
     * Get bookAuthor
     *
     * @return string
     */
    public function getBookAuthor()
    {
        return $this->bookAuthor;
    }

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return Book
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set yearPublished
     *
     * @param \DateTime $yearPublished
     *
     * @return Book
     */
    public function setYearPublished($yearPublished)
    {
        $this->yearPublished = $yearPublished;

        return $this;
    }

    /**
     * Get yearPublished
     *
     * @return \DateTime
     */
    public function getYearPublished()
    {
        return $this->yearPublished;
    }

    /**
     * Set submittedBy
     *
     * @param \Blogger\BlogBundle\Entity\User $submittedBy
     *
     * @return Book
     */
    public function setSubmittedBy(\Blogger\BlogBundle\Entity\User $submittedBy = null)
    {
        $this->submittedBy = $submittedBy;

        return $this;
    }

    /**
     * Get submittedBy
     *
     * @return \Blogger\BlogBundle\Entity\User
     */
    public function getSubmittedBy()
    {
        return $this->submittedBy;
    }

    /**
     * Set timeStamp
     *
     * @param \DateTime $timeStamp
     *
     * @return Book
     */
    public function setTimeStamp($timeStamp)
    {
        $this->timeStamp = $timeStamp;

        return $this;
    }

    /**
     * Get timeStamp
     *
     * @return \DateTime
     */
    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    /**
     * @return mixed
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param mixed $posts
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }




}

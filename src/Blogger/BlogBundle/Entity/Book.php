<?php

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Book
 *
 * @ORM\Table(name="books")
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Repository\UserRepository")
 */
class Book
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @var \Blogger\BlogBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="Blogger\BlogBundle\Entity\User", inversedBy="books")
     * @ORM\JoinColumn(name="submitted_by", referencedColumnName="id")
     */
    private $submitted_by;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="book_author", type="string", length=255)
     */
    private $bookAuthor;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=255, nullable=true)
     */
    private $picture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="year_published", type="date", nullable=true)
     */
    private $yearPublished;


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
        $this->submitted_by = $submittedBy;

        return $this;
    }

    /**
     * Get submittedBy
     *
     * @return \Blogger\BlogBundle\Entity\User
     */
    public function getSubmittedBy()
    {
        return $this->submitted_by;
    }
}

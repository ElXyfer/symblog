<?php

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Album
 *
 * @ORM\Table(name="album")
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Repository\AlbumRepository")
 */
class Album
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
     * @ORM\Column(name="AlbumName", type="string", length=255)
     */
    private $albumName;


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
     * Set albumName
     *
     * @param string $albumName
     *
     * @return Album
     */
    public function setAlbumName($albumName)
    {
        $this->albumName = $albumName;

        return $this;
    }

    /**
     * Get albumName
     *
     * @return string
     */
    public function getAlbumName()
    {
        return $this->albumName;
    }
}

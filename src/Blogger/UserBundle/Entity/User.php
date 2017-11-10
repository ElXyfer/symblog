<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="ws_user")
 * @ORM\Entity(repositoryClass="Blogger\UserBundle\Repository\UserRepository")
 */
class User extends  BaseUser
{

    /**
     * @ORM\OneToMany(targetEntity="Blogger\BlogBundle\Entity\Post", mappedBy="user")
     */
    private $posts;

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
    }

}

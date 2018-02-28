<?php
/**
 * Created by PhpStorm.
 * User: lincolnchawora
 * Date: 15/02/2018
 * Time: 14:54
 */

namespace Blogger\BlogBundle\Controller;

use Blogger\BlogBundle\Entity\Post;
use Blogger\BlogBundle\Form\PostType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends FOSRestController
{

    public function getBlogpostsAction($id){
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository('BloggerBlogBundle:Post')->find($id);

        if(!$post) {
            $view = $this->view(null, 404);
        } else {
            $view = $this->view($post);
        }

        return $this->handleView($view);
    }

}
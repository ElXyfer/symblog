<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PageController extends Controller
{
    public function getCurrentUserID() {
        if ($this->getUser())
        {
            return $this->getUser()->getId();
        } else {
            return null;
        }
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $blogPost = $em->getRepository('BloggerBlogBundle:Post')
                ->getLatest(10, 0, $this->getCurrentUserID());
        return $this->render('BloggerBlogBundle:Page:index.html.twig',
            ['blogposts' => $blogPost]);

    }

    public function aboutAction()
    {
        return $this->render('BloggerBlogBundle:Page:about.html.twig');
    }

}

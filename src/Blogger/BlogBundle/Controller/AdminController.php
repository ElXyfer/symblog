<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function viewAction()
    {
        return $this->render('BloggerBlogBundle:Admin:view.html.twig', array(
            // ...
        ));
    }

    public function editAction()
    {
        return $this->render('BloggerBlogBundle:Admin:edit.html.twig', array(
            // ...
        ));
    }

    public function deleteAction()
    {
        return $this->render('BloggerBlogBundle:Admin:delete.html.twig', array(
            // ...
        ));
    }

}

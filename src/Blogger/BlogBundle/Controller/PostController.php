<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Post;
use Blogger\BlogBundle\Form\PostType;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
    public function viewAction($id)
    {
        // Get the doctrine entity manager
        $em = $this->getDoctrine()->getManager();

        // Use the entity manager to retrieve the Post entity for the id that has been passed
        $blogPost = $em->getRepository('BloggerBlogBundle:Post')->find($id);

        // Pass the Post entity to the view for displaying
        return $this->render('BloggerBlogBundle:Post:view.html.twig',
            ['post' => $blogPost]);
    }

    public function createAction(Request $request)
    {
        // Create an new (empty) Post entity
        $blogPost = new Post();

        // Create a form from the PostType class to be validated
        // against the Post entity and set the form action attribute to the current URI
        $form = $this->createForm(PostType::class, $blogPost, [
            'action' => $request->getUri()
        ]);

        // If the request is post it will populate the form
        $form->handleRequest($request);

        // validate the form
        if($form->isValid()) {

            // Retrieve the doctrine entity manager
            $em = $this->getDoctrine()->getManager();

            // manually set the user to the current user
            $blogPost->setUser($this->getUser());

            // manually set the date published to a new date time object
            $blogPost->setPublished(new  \DateTime());

            // tell the entity manager we want to persist this entity
            $em->persist($blogPost);

            // commit all changes
            $em->flush();

            // Render the view from the twig file and pass the from to the view
            return $this->redirect($this->generateUrl('blogger_post_view',
                ['id' => $blogPost->getId()]));
        }


        return $this->render('BloggerBlogBundle:Post:create.html.twig',
            ['form' => $form->createView()]);

    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $blogPost = $em->getRepository('BloggerBlogBundle:Post')->find($id);
        $form = $this->createForm(PostType::class, $blogPost,
            ['action' => $request->getUri()
            ]);

        $form->handleRequest($request);

        if($form->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('blogger_post_view',
                ['id' => $blogPost->getId()]));

        }

        return $this->render('BloggerBlogBundle:Post:edit.html.twig',
            ['form' => $form->createView(),
                'post' => $blogPost]);
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $blogPost = $em->getRepository('BloggerBlogBundle:Post')->find($id);

        $em->remove($blogPost);
        $em->flush();
        return $this->redirect($this->generateUrl('blogger_blog_homepage'));
    }

}

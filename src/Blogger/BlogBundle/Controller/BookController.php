<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Book;
use Blogger\BlogBundle\Form\BookType;
use Symfony\Component\HttpFoundation\Request;

class BookController extends Controller
{
    public function viewAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $bookPost = $entityManager->getRepository('BloggerBlogBundle:Book')->find($id);

        return $this->render('BloggerBlogBundle:Book:view.html.twig',
            ['book' => $bookPost]);

    }

    public function createAction(Request $request)
    {
        $bookPost = new Book(null);

        $form = $this->createForm(BookType::class, $bookPost,[
            'action' => $request->getUri()
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted()) {

            $entityManager = $this->getDoctrine()->getManager();

            $bookPost->setSubmittedBy($this->getUser());

            $bookPost->setTimeStamp(new \DateTime());

            $entityManager->persist($bookPost);

            $entityManager->flush();

            return $this->redirect($this->generateUrl('blogger_book_view',
                ['id' => $bookPost->getId()]));
        }

        return $this->render('BloggerBlogBundle:Book:create.html.twig',
            ['form' => $form->createView()]);
    }

    public function editAction($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $bookPost = $entityManager->getRepository('BloggerBlogBundle:Book')->find($id);

        $form = $this->createForm(BookType::class, $bookPost,
            ['action' => $request->getUri()
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $entityManager->flush();

            return $this->redirect($this->generateUrl('blogger_book_view',
                ['id' => $bookPost->getId()]));
        }

        return $this->render('BloggerBlogBundle:Book:edit.html.twig',
            ['form' => $form->createView(),
            'book' => $bookPost]);
    }

    public function deleteAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $bookPost = $entityManager->getRepository('BloggerBlogBundle:Book')->find($id);

        $entityManager->remove($bookPost);

        $entityManager->flush();

        return $this->redirect($this->generateUrl('blogger_blog_homepage'));
    }

}

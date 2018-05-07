<?php
/**
 * Created by PhpStorm.
 * User: lincolnchawora
 * Date: 15/02/2018
 * Time: 14:54
 */

namespace Blogger\BlogBundle\Controller;

use Blogger\BlogBundle\BloggerBlogBundle;
use Blogger\BlogBundle\Entity\Book;
use Blogger\BlogBundle\Entity\Post;
use Blogger\BlogBundle\Form\BookType;
use Blogger\BlogBundle\Form\PostType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class APiBookController extends FOSRestController
{

    public function getBooksAction(){
        $em = $this->getDoctrine()->getManager();

        $books = $em->getRepository('BloggerBlogBundle:Book')->findAll();

        if(empty($books)) {
            $view = $this->view(null, 404);
        } else {
            $view = $this->view($books);
        }

        return $this->handleView($view);
    }

    public function getBookAction($id) {
        $em = $this->getDoctrine()->getManager();

        $book = $em->getRepository("BloggerBlogBundle:Book")->find($id);

        if (!empty($book)) {
            return $this->handleView($this->view($book, 200));
        }

        $view = $this->view(null, 404);
        return $this->handleView($view);
    }

    public function postBookAction(Request $request) {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);

        if($request->getContentType() != 'json') {
            return $this->handleView($this->view(null, 400));
        }

        $form->submit(json_decode($request->getContent(), true));

        if($form->isValid()) {
            $EntityManager = $this->getDoctrine()->getManager();
            $book->setSubmittedBy($this->getUser());
            $book->setTimeStamp(new \DateTime());
            $EntityManager->persist($book);
            $EntityManager->flush();

            return $this->handleView($this->view(null, 201)
                ->setLocation(
                    $this->generateUrl('api_book_get_book', ['id' => $book->getId()]
                    )
                )
            );

        } else {
            return $this->handleView($this->view($form, 400));
        }
    }

    public function putBookAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $book = $em->getRepository('BloggerBlogBundle:Book')->find($id);

        $form = $this->createForm(BookType::class, $book);

        if($request->getContentType() != 'json') {
            return $this->handleView($this->view(null, 400));
        }

        $form->submit(json_decode($request->getContent(), true));

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $book->setSubmittedBy($this->getUser());
            $book->setTimeStamp(new \DateTime());
            $em->persist($book);
            $em->flush();

            return $this->handleView($this->view(null, 201)
                ->setLocation(
                    $this->generateUrl('api_book_get_book', ['id' => $book->getId()]
                    )
                )
            );

        } else {
            return $this->handleView($this->view($form, 400));
        }

    }

    public function deleteBookAction($id) {
        $em = $this->getDoctrine()->getManager();

        $book = $em->getRepository("BloggerBlogBundle:Book")->find($id);

        if (!empty($book)) {
            $em->remove($book);
            $em->flush();

            return $this->handleView($this->view("Book has been removed", 202));
        }

        $view = $this->view(null, 404);
        return $this->handleView($view);
    }


}
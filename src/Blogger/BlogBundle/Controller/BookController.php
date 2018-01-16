<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Book;
use Blogger\BlogBundle\Form\BookType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class BookController extends Controller
{
    public function viewAction($id)
    {
        // get doctrine manager
        $entityManager = $this->getDoctrine()->getManager();

        // get book repository
        $bookPost = $entityManager->getRepository('BloggerBlogBundle:Book')->find($id);

        // if theres no post, redirect
        if(empty($bookPost)){
            return $this->redirect($this->generateUrl('index'));
        }

//        if($bookPost->getSubmittedBy()->getId() != $this->getUser()->getId()) {
//            return $this->redirect($this->generateUrl('index'));
//        }

        // go to book view
        return $this->render('BloggerBlogBundle:Book:view.html.twig',
            ['book' => $bookPost]);

    }

    // passing book post
    public function FileHelper(Book $bookPost) {

        /**
         * @var UploadedFile $file
         */

        // gets picture using get method
        $file = $bookPost->getPicture();

        // Generate a unique name for the file before saving it
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        // Move the picture to the directory where pictures are stored
        $file->move(
            $this->getParameter('picture_directory'), $fileName
        );

        // Update the 'picture' property to store the picture file name
        $bookPost->setPicture($fileName);


    }

    // passing request
    public function createAction(Request $request)
    {
        //creating a new book
        $bookPost = new Book(null);

        $form = $this->createForm(BookType::class, $bookPost,[
            'action' => $request->getUri()
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted()) {

            $entityManager = $this->getDoctrine()->getManager();

            // set submitted by and get logged in user
            $bookPost->setSubmittedBy($this->getUser());

            $bookPost->setTimeStamp(new \DateTime());

            $this->FileHelper($bookPost);

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

            $this->FileHelper($bookPost);

            $entityManager->persist($bookPost);

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

        return $this->redirect($this->generateUrl('index'));
    }

}

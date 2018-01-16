<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

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

    public function indexAction(){
//        $em = $this->getDoctrine()->getManager();
//        $blogPost = $em->getRepository('BloggerBlogBundle:Post')
//            ->getLatest(10, 0, $this->getCurrentUserID());
//        return $this->render('BloggerBlogBundle:Page:index.html.twig',
//            ['blogposts' => $blogPost]);

        $entityManager = $this->getDoctrine()->getManager();
        $bookPost = $entityManager->getRepository('BloggerBlogBundle:Book')
                ->getLatest(10, 0, null); //
        return $this->render('BloggerBlogBundle:Page:index.html.twig',
            ['bookposts' => $bookPost]);
    }

    public function authorAction()
    {
        $em = $this->getDoctrine()->getManager();
        $blogPosts = $em->getRepository('BloggerBlogBundle:Post')
                ->getLatest(10, 0, $this->getCurrentUserID());
        return $this->render('BloggerBlogBundle:Page:author.html.twig',
            ['blogposts' => $blogPosts]);

    }

    public function paginationAction($page = 1) {
        // limit of books per page
        $booksPerPage = 3;

        $entityManager = $this->getDoctrine()->getManager();

        // call count books from book repo
        $bookCount = $entityManager->getRepository('BloggerBlogBundle:Book')->countBooks();

        $pageCount = ceil($bookCount / $booksPerPage);

        $bookPosts = $entityManager->getRepository('BloggerBlogBundle:Book')
            ->getPage($booksPerPage, $page, $this->getCurrentUserID());

        return $this->render('BloggerBlogBundle:Page:index.html.twig',
            ['bookposts' => $bookPosts, 'pagecount' => $pageCount]);
    }



    public function strangerAction($id = 1) {

        $em = $this->getDoctrine()->getManager();

        $blogPosts = $em->getRepository('BloggerBlogBundle:Post')->getLatest(10, 0, $id);

        if(empty($blogPosts)){
            return $this->redirect($this->generateUrl('index'));
        }

        return $this->render('BloggerBlogBundle:Page:author.html.twig',
            ['blogposts' => $blogPosts]);
    }

    public function searchAction() {
        $form = $this->createFormBuilder(null)
            ->add('search', TextType::class)
            ->getForm();

        return $this->render("BloggerBlogBundle:Page:search.html.twig", [
            'form' => $form->createView()
        ]);
    }

    public function handleSearchAction(Request $request) {

        // get repo
        $bookRepo = $this->getDoctrine()->getRepository('BloggerBlogBundle:Book');

        $string = $request->request->get('form')['search'];

        $books = $bookRepo->getSearchResults($string);

        return $this->render("BloggerBlogBundle:Page:result.html.twig", [
            'books' => $books
        ]);
    }


}

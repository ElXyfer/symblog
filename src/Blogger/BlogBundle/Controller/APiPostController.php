<?php
/**
 * Created by PhpStorm.
 * User: lincolnchawora
 * Date: 06/05/2018
 * Time: 16:57
 */

namespace Blogger\BlogBundle\Controller;

use  Blogger\BlogBundle\Entity\Post;
use Blogger\BlogBundle\Form\PostType;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class APiPostController extends FOSRestController
{
    public function getPostsAction($bookId) {
        $em = $this->getDoctrine()->getManager();

        $book = $em->getRepository('BloggerBlogBundle:Book')->find($bookId);

        $posts = $book->getPosts();

        if(empty($posts)) {
            $view = $this->view("No posts have been found for this book", 404);
        } else {
            $view = $this->view($posts);
        }

        return $this->handleView($view);
    }

    public function getPostAction($bookId, $postId) {
        $em = $this->getDoctrine()->getManager();

        $book = $em->getRepository("BloggerBlogBundle:Book")->find($bookId);

        $post = $em->getRepository('BloggerBlogBundle:Post')->find($postId);


        if(!empty($post)) {
            return $this->handleView($this->view($post, 200));
        }

        $view = $this->view(null, 404);

        return $this->handleView($view);
    }

    public function postPostAction(Request $request, $bookId) {

        $blogPost = new Post();

        $em = $this->getDoctrine()->getManager();

        $book = $em->getRepository("BloggerBlogBundle:Book")->find($bookId);

        if(empty($book)) {
            return $this->handleView($this->view(null, 400));
        }

        $form = $this->createForm(PostType::class, $blogPost, [
            'action' => $request->getUri()
        ]);

        if($request->getContentType() != 'json') {
            return $this->handleView($this->view(null, 400));
        }

        $form->submit(json_decode($request->getContent(), true));

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $blogPost->setUser($this->getUser());

            $blogPost->setPublished(new \DateTime());

            $blogPost->setBook($book);

            $em->persist($blogPost);

            $em->flush();

            return $this->handleView($this->view(null, 201)
                ->setLocation(
                    $this->generateUrl('api_post_get_book_post', ['id' => $blogPost->getId()])
                )
            );
        } else {
            return $this->handleView($this->view($form, 400));
        }

    }

    public function putPostAction(Request $request, $bookId, $postId) {

        if(!$this->getUser()) {
            return $this->handleView($this->view(null, 401));
        }

        $em = $this->getDoctrine()->getManager();

        $book = $em->getRepository("BloggerBlogBundle:Book")->find($bookId);

        if (empty($book)) {
            return $this->handleView($this->view(null, 400));
        }

        $blogPost = $em->getRepository("BloggerBlogBundle:Post")->find($postId);

        if (empty($blogPost)) {
            return $this->handleView($this->view(null, 204));
        }

        if($this->getUser() != $blogPost->getUser()) {
            return $this->handleView($this->view(null, 403));
        }

        $form = $this->createForm(PostType::class, $blogPost, [
            'action' => $request->getUri()
        ]);

        if($request->getContentType() != 'json') {
            return $this->handleView($this->view(null, 400));
        }

        $form->submit(json_decode($request->getContent(), true));

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->handleView($this->view(null, 202)
                ->setLocation(
                    $this->generateUrl('api_post_put_book_post',
                        ['postId' => $blogPost->getId(), 'id' => $book->getId()]
                    )
                )
            );
        }

        return $this->handleView($this->view($form, 400));


    }

    public function deletePostAction($bookId, $postId) {

        $em = $this->getDoctrine()->getManager();

        $book = $em->getRepository("BloggerBlogBundle:Book")->find($bookId);

        $blogPost = $em->getRepository("BloggerBlogBundle:Post")->find($postId);

        if($blogPost->getUser() != $this->getUser()) {
            return $this->handleView($this->view("You cannot remove this post as it does not belong to you.", 401));
        }

        if(!empty($blogPost)) {
            $em->remove($blogPost);
            $em->flush();

            return $this->handleView($this->view("Post has been removed", 202));
        }

        $view = $this->view(null, 404);
        return $this->handleView($view);
    }

}
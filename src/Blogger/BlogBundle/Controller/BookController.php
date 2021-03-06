<?php

namespace Blogger\BlogBundle\Controller;

use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Book;
use Blogger\BlogBundle\Form\BookType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;


class BookController extends Controller
{

    private $volumes;
    private $GBclient;
    private $NYTClient;


    public function SetUpClient() {
        $this->GBclient = new Client(["base_uri" => "https://www.googleapis.com/books/v1/"]);
        $this->NYTClient = new Client(["base_uri" => "https://api.nytimes.com/svc/books/v3/"]);
    }

    public function __construct()
    {
        $this->SetUpClient();
    }

    // API Actions
    public function apiSearchAction() {

        $form = $this->createFormBuilder(null)
            ->add('search', TextType::class)
            ->getForm();

        return $this->render("BloggerBlogBundle:Book:api-search.html.twig", [
            'form' => $form->createView()
        ]);
    }

    public function handleSearchAction(Request $request) {
        $searchString = $request->request->get('form')['search'];

        $response = $this->GBclient->get('volumes?q='.$searchString);

        $resBody = $response->getBody();
        $results = \GuzzleHttp\json_decode($resBody);
        $this->volumes = $results->items;

        return $this->render("BloggerBlogBundle:Book:api-results.html.twig", [
            'items' => $this->volumes
        ]);
    }

    public function apiBookAction($id){

        $response = $this->GBclient->get('volumes?q=id='.$id);

        $resBody = $response->getBody();
        $results = \GuzzleHttp\json_decode($resBody);
        $item = $results->items[0];

        return $this->render('BloggerBlogBundle:Book:api-result.html.twig',
            ["item" => $item]);

    }

    public function bestSellerAction() {

        $response = $this->NYTClient->get("lists/best-sellers/history.json?api-key=80419214bff441f08ba2298db696ff4f");

        $resBody = $response->getBody();

        $results = \GuzzleHttp\json_decode($resBody);

//        return $this->render(var_dump($results->results));

        return $this->render("BloggerBlogBundle:Book:api-best-sellers.html.twig", [
            'results' => $results->results
        ]);

    }


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

        $response = $this->GBclient->get('volumes?q='.$bookPost->getTitle());
        $resBody = $response->getBody();
        $results = \GuzzleHttp\json_decode($resBody);
        $item = $results->items[0];

        // go to book view
        return $this->render('BloggerBlogBundle:Book:view.html.twig',
            ['book' => $bookPost, 'item'=> $item]);

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
        $bookPost = new Book();

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

    public function editAction(Request $request, $id)
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

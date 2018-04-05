<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GuzzleHttp\Client;

class JoindinController extends Controller
{
    private $events;
    private $client;

    public function SetUpClient(){
        $client = new Client(["base_uri" => "https://api.joind.in/v2.1/"]);
        $response = $client->get('events?filter=post');
        $respBody = $response->getBody();
        $results = \GuzzleHttp\json_decode($respBody);
        $this->events = $results->events;
        $this->client = $client;
    }

    public function __construct()
    {
        $this->SetUpClient();
    }

    public function eventsAction()
    {
        return $this->render('BloggerBlogBundle:Joindin:events.html.twig', ["events" => $this->events]);
    }

    public function eventAction($index)
    {
        $event = $this->events[$index - 1];
        return $this->render('BloggerBlogBundle:Joindin:event.html.twig', ["event" => $event]);

    }


    public function talksAction($index)
    {
        $event = $this->events[$index - 1];

        $parsedUrl = parse_url($event->uri);

        $temp = explode("/", $parsedUrl["path"]);

        $id = end($temp);

        $talks = [];

        if($event->talks_count > 0) {
            $talks = $this->getTalksForEvent($id);
        }

        return $this->render('BloggerBlogBundle:Joindin:talks.html.twig', ["talks" => $this->$talks]);

    }

    public function getTalksForEvent($eventId) {
        $response = $this->client->get("events/" . $eventId . "/talks");

        $respBody = $response->getBody();

        $results = \GuzzleHttp\json_decode($respBody);

        return $results->talks;

    }

}

<?php
/**
 * Created by PhpStorm.
 * User: lincolnchawora
 * Date: 03/11/2017
 * Time: 18:26
 */

namespace AppBundle\EventListener;


use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class RedirectAfterRegistrationSubscriber implements EventSubscriberInterface
{
    use TargetPathTrait;
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onRegistrationSuccess(FormEvent $event)
    {
        $url = $this->getTargetPath($event->getRequest()->getSession(), 'main');

        if(!$url){
            // creates url (index)
            $url = $this->router->generate('index');
        }


        // create a re direct response
        $response = new RedirectResponse($url);
        // event sets response
        $event->setResponse($response);


    }

    public static function getSubscribedEvents()
    {
        // tracks the registration even, gets an event
        return[
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess'
        ];
    }
}
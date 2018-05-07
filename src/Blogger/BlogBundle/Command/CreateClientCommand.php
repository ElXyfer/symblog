<?php

namespace Blogger\BlogBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class CreateClientCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName("oauth:add-client")->setDescription("Adds new client for OAuth");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $redirectUri = $this->getContainer()->getParameter("router.request_context.scheme") . "://" . $this->getContainer()->getParameter("router.request_context.host");

        $clientManager = $this->getContainer()->get("fos_oauth_server.client_manager.default");

        $client = $clientManager->createClient();

        $client->setRedirectUris(array($redirectUri));

//        $client->setAllowedGrantTypes(array("token", "authorization_code"));
        $client->setAllowedGrantTypes(array("refresh_token", "password"));

        $clientManager->updateClient($client);
    }
}
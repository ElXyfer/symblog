<?php

namespace Blogger\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testView()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'admin_view');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'admin_edit');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'admin_delete');
    }

}

<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccountControllerTest extends WebTestCase
{
    public function testNewevent()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/newEvent');
    }

    public function testJoinevent()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/joinEvent');
    }

    public function testEditevent()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editEvent');
    }

}

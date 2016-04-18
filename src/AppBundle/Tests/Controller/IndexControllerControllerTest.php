<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerControllerTest extends WebTestCase
{
    public function testEventsindex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/eventsIndex');
    }

    public function testEventsupcomming()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/eventsUpcomming');
    }

    public function testEventdetails()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/eventDetails');
    }

}

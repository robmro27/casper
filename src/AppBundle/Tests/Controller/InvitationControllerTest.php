<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InvitationControllerTest extends WebTestCase
{
    public function testInvite()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/invite');
    }

    public function testAccept()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/accept');
    }

    public function testCancel()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/cancel');
    }

    public function testReject()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/reject');
    }

}

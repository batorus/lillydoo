<?php

namespace LillydooBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addressbook/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Addressbook', $client->getResponse()->getContent());
    }
}

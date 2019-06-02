<?php

namespace LillydooBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddressbookControllerTest extends WebTestCase
{
    /*
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/addressbook/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /addressbook/");
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'lillydoobundle_addressbook[field_name]'  => 'Test',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Update')->form(array(
            'lillydoobundle_addressbook[field_name]'  => 'Foo',
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "Foo"
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Foo/', $client->getResponse()->getContent());
    }

    */
    
    
    public function test_when_click_addnewrecord_redirects_to_addressbook_new(){
        
        $client = static::createClient();
        $crawler = $client->request('GET', '/addressbook/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /addressbook/");
        $crawler = $client->click($crawler->selectLink('Add New Record')->link());

        $this->assertContains('Addressbook creation', $client->getResponse()->getContent());
        
        //this is more specific
        $this->assertContains('Addressbook creation', $crawler->filter('main h1')->text());
        
    }
    
    public function test_when_click_save_new_record_validation_messages_appear(){
        
        $client = static::createClient();
        $crawler = $client->request('GET', '/addressbook/new');
//        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /addressbook/");
//        $crawler = $client->click($crawler->selectLink('Add New Record')->link());
        
        //test element exists
        $this->assertEquals("lillydoobundle_addressbook[firstname]",  
                            $crawler->filter('body form table tbody')
                                    ->children()
                                    ->eq(0)->children()
                                           ->eq(1)
                                              ->children()
                                              ->eq(0)
                                              ->attr("name"));
        
         $form = $crawler->selectButton('Save')->form(array(
            'lillydoobundle_addressbook[firstname]'  => ""
        ));
         
        $uri = $client->submit($form)->getUri();
        $this->assertContains('The value for first name should not be blank!', $client->getResponse()->getContent());
        
       // var_dump($uri);die();
       // $crawler = $client->followRedirect();
        
//        $crawler = $crawler->filter("tbody > tr");
//        $nodeValues = $crawler->each(
//                function ($node, $i) {
//                        $first = $node->children()->first()->text();
//                        $last = $node->children()->eq(2)->html();
//                        return array($first, $last);
//                }
//        );

       //$this->assertRegExp('/foo(bar)?/', $client->getResponse()->getContent());
//       $this->assertTrue(
//            $client->getResponse()->isRedirect()
//            // if the redirection URL was generated as an absolute URL
//            // $client->getResponse()->isRedirect('http://localhost/demo/contact')
//        );
      //print_r($client->getResponse()->headers->keys()); die();
//        $this->assertEquals("This value should not be blank!",  
//                            $crawler->filter('body form table tbody')
//                                    ->children()
//                                    ->eq(0)->children()
//                                           ->eq(2)
//                                              ->children()
//                                              ->eq(0)->html()
//                                              );
        
       // var_dump($client->getResponse()->getContent());die();
//                            $crawler->filter('body form table tbody')
//                                    ->children()
//                                    ->eq(0)
//        $this->assertContains('This value should not be blank!', $client->getResponse()->getContent());
//        $this->assertContains('This value should not be blank!', 
//                                           $crawler->filter('body form table tbody')
//                                         
//                                           );        
//        var_dump(    $crawler->filter('body form table tbody')
//                                      ->children()
//                                      ->eq(0)->children()
//                                           ->eq(2)
////                                              ->children()
////                                              ->eq(0)
//                                            ->html());die();
                                                
//        $this->assertContains('This value should not be blank!', 
//                              $crawler->filter('body')
//                                      ->children()
//                                      ->eq(1)->children()
//                                             ->eq(3)
//                                             ->text());
        
    }
}

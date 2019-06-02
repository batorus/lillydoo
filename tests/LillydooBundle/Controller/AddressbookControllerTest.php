<?php

namespace LillydooBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddressbookControllerTest extends WebTestCase
{
   
    public function test_when_click_add_new_record_redirects_to_addressbook_new(){
        
        $client = static::createClient();
        $crawler = $client->request('GET', '/addressbook/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /addressbook/");
        $crawler = $client->click($crawler->selectLink('Add New Record')->link());

        $this->assertContains('Addressbook creation', $client->getResponse()->getContent());        
        //this is more specific
        $this->assertContains('Addressbook creation', $crawler->filter('main h1')->text());       
    }
    
    public function test_when_click_save_new_record_empty_firstname_error_message(){
        
        $client = static::createClient();
        $crawler = $client->request('GET', '/addressbook/new');
      
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
         
        $client->submit($form);
        $this->assertContains('The value for first name should not be blank!', $client->getResponse()->getContent());
        
      
    }
    
    public function test_click_save_new_record_empty_email_error_message_is_displayed()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/addressbook/new');

         $form = $crawler->selectButton('Save')->form(array(
            'lillydoobundle_addressbook[email]'  => ""
        ));
         
        $client->submit($form);
        $this->assertContains('The value for email should not be blank!', $client->getResponse()->getContent()); 
    }
    
    /**
    * @dataProvider provideBrokenEmailAddresses
    */
    public function test_click_save_new_record_not_valid_email_error_message_is_displayed($email)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/addressbook/new');

        
         $form = $crawler->selectButton('Save')->form(array(
            'lillydoobundle_addressbook[email]'  => $email
        ));
         
        $client->submit($form);
        $this->assertContains('Not a valid email address!', $client->getResponse()->getContent()); 
    }
    
    public function provideBrokenEmailAddresses()
    {
        return [
            ['abc'],
            ['abc@'],
            ['abc@def'],
            ['@def'],
            ['@def.com'],
            ['def.com'],    
            ['.com'],
        ];
   }
  
#######################Tests that interact with the db   
//    public function test_click_save_new_record_with_valid_data_creates_new_record_in_db()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/addressbook/new');
//       
//        $form = $crawler->selectButton('Save')->form(array(
//           'lillydoobundle_addressbook[firstname]'  => "AAA",
//           'lillydoobundle_addressbook[lastname]'  => "Bar",        
//           'lillydoobundle_addressbook[street]'  => "12345 street",
//           'lillydoobundle_addressbook[number]'  => "1234",
//           'lillydoobundle_addressbook[country]'  => "Romania",
//           'lillydoobundle_addressbook[phonenumber]'  => "123456789",        
//           'lillydoobundle_addressbook[birthday]'  => "2019-06-05",
//           'lillydoobundle_addressbook[email]'  => "email@test.com",     
//           'lillydoobundle_addressbook[zipcode]'  => "zipcodetest",            
//        ));
//         
//        $client->submit($form);
//        $crawler = $client->followRedirect();
//
//        // Check data in the show view
//        $this->assertGreaterThan(0, $crawler->filter('td:contains("AAA")')->count());   
//        $this->assertGreaterThan(0, $crawler->filter('td:contains("Bar")')->count());    
//        $this->assertGreaterThan(0, $crawler->filter('td:contains("12345 street")')->count());   
//        $this->assertGreaterThan(0, $crawler->filter('td:contains("1234")')->count()); 
//        $this->assertGreaterThan(0, $crawler->filter('td:contains("Romania")')->count());   
//        $this->assertGreaterThan(0, $crawler->filter('td:contains("123456789")')->count());    
//        $this->assertGreaterThan(0, $crawler->filter('td:contains("2019-06-05")')->count());   
//        $this->assertGreaterThan(0, $crawler->filter('td:contains("email@test.com")')->count());     
//        $this->assertGreaterThan(0, $crawler->filter('td:contains("zipcodetest")')->count());  
//
//    }
//    
//    public function test_edit_entity()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/addressbook/');
//
//        $link = $crawler
//                ->filter('a:contains("Edit")') // find all links with the text "Greet"
//                ->eq(0)
//                ->link()
//;
//        //$crawler->selectLink('Edit')->eq(0)->link()
//        $crawler = $client->click($link);
//        $this->assertContains('Addressbook edit', $client->getResponse()->getContent());
//
//        $form = $crawler->selectButton('Save')->form(array(
//           'lillydoobundle_addressbook[firstname]'  => "AAA",
//        ));
//        
//        //$this->assertGreaterThan(0, $crawler->filter('[value="Fooo"]')->count());
//        
//        $client->submit($form);
//        $crawler = $client->followRedirect();
//        
//        $this->assertGreaterThan(0, $crawler->filter('td:contains("AAA")')->count()); 
//    }
//    
//    public function test_delete_entity()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/addressbook/');
//        
//        $link = $crawler
//                ->filter('a:contains("Delete")') // find all links with the text "Greet"
//                ->eq(0)
//                ->link();
//
//        $crawler = $client->click($link);
//        $crawler = $client->followRedirect();
//
//        // Check the entity has been delete on the list
//        $this->assertNotRegExp('/AAA/', $client->getResponse()->getContent());
//    }
      
}

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
   
    public function test_click_save_new_record_with_valid_data_creates_new_record_in_db()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/addressbook/new');
       
        $form = $crawler->selectButton('Save')->form(array(
           'lillydoobundle_addressbook[firstname]'  => "first",
           'lillydoobundle_addressbook[lastname]'  => "last",        
           'lillydoobundle_addressbook[street]'  => "12345 street",
           'lillydoobundle_addressbook[number]'  => "1234",
           'lillydoobundle_addressbook[country]'  => "Romania",
           'lillydoobundle_addressbook[phonenumber]'  => "123456789",        
           'lillydoobundle_addressbook[birthday]'  => "2019-06-05",
           'lillydoobundle_addressbook[email]'  => "email@test.com",     
           'lillydoobundle_addressbook[zipcode]'  => "zipcodetest",            
        ));
         
        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("first")')->count());   
        $this->assertGreaterThan(0, $crawler->filter('td:contains("last")')->count());    
        $this->assertGreaterThan(0, $crawler->filter('td:contains("12345 street")')->count());   
        $this->assertGreaterThan(0, $crawler->filter('td:contains("1234")')->count()); 
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Romania")')->count());   
        $this->assertGreaterThan(0, $crawler->filter('td:contains("123456789")')->count());    
        $this->assertGreaterThan(0, $crawler->filter('td:contains("2019-06-05")')->count());   
        $this->assertGreaterThan(0, $crawler->filter('td:contains("email@test.com")')->count());     
        $this->assertGreaterThan(0, $crawler->filter('td:contains("zipcodetest")')->count());         
    }
    
    public function test_edit_entity()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/addressbook/');

        $crawler = $client->click($crawler->selectLink('Edit')->link());
        $this->assertContains('Addressbook edit', $client->getResponse()->getContent());

        $form = $crawler->selectButton('Save')->form(array(
           'lillydoobundle_addressbook[firstname]'  => "Foo",
        ));
        
        $this->assertGreaterThan(0, $crawler->filter('[value="Foo"]')->count(), 'Missing element [value="Foo"]');
        
        $client->submit($form);
        $crawler = $client->followRedirect();
        
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Foo")')->count()); 
    }
    
    
}

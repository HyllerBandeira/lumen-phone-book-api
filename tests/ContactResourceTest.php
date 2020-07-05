<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class ContactResourceTest extends TestCase
{
    /**
     * Test contact listing.
     *
     * @return void
     */
    public function testListingAllContacts()
    {
        $response = $this->call('GET', '/contacts');
    
        $this->assertEquals(200, $response->status());
    }
    
    /**
     * Test Create Valid Contact.
     *
     * @return void
     */
    public function testCreateValidContact()
    {
        $response = $this->call('POST', '/contacts', [ 
            'name' => 'Hyller Bandeira Dutra', 
            'address' => 'Paschoal Bettoni, 4, 03627-220',
            'phone' => '(15) 99658-5369',
            'email' => 'hyller.bandeira@gmail.com'
        ]);

        $this->assertEquals(201, $response->status());
    }
    
    /**
     * Test Create Contact using Invalid email address.
     *
     * @return void
     */
    public function testCreateNonValidEmailContact()
    {
        $response = $this->call('POST', '/contacts', [ 
            'name' => 'Hyller Bandeira Dutra', 
            'address' => 'Paschoal Bettoni, 4, 03627-220',
            'phone' => '(15) 99658-5369',
            'email' => 'hyller.bandeira.gmail'
        ]);
        
        $this->assertEquals(400, $response->status());
    }
    
    /**
     * Test Create Contact using Invalid phone address.
     *
     * @return void
     */
    public function testCreateNonValidPhoneContact()
    {
        $response = $this->call('POST', '/contacts', [ 
            'name' => 'Hyller Bandeira Dutra', 
            'address' => 'Paschoal Bettoni, 4, 03627-220',
            'phone' => '(15) 99658-53',
            'email' => 'hyller.bandeira@gmail.com'
        ]);
        
        $this->assertEquals(400, $response->status());
    }

    /**
     * Test Show Contact.
     *
     * @return void
     */
    public function testShowContact()
    {
        $contact_id = $this->createNewContact();

        $response = $this->call('GET', "/contacts/{$contact_id}");
    
        $this->assertEquals(200, $response->status());
    }
    
    /**
     * Test Update Valid Contact.
     *
     * @return void
     */
    public function testUpdateValidContact()
    {
        $contact_id = $this->createNewContact();

        $response = $this->call('PUT', "/contacts/{$contact_id}", [ 
            'name' => 'Hyller Bandeira Dutra', 
            'address' => 'Paschoal Bettoni, 4, 03627-220',
            'phone' => '(15) 99658-5369',
            'email' => 'hyller.bandeira@gmail.com'
        ]);

        $this->assertEquals(201, $response->status());
    }
    
    /**
     * Test Update Contact using Invalid email address.
     *
     * @return void
     */
    public function testUpdateNonValidEmailContact()
    {
        $contact_id = $this->createNewContact();

        $response = $this->call('PUT', "/contacts/{$contact_id}", [
            'name' => 'Hyller Bandeira Dutra', 
            'address' => 'Paschoal Bettoni, 4, 03627-220',
            'phone' => '(15) 99658-5369',
            'email' => 'hyller.bandeira.gmail'
        ]);

        $this->assertEquals(400, $response->status());
    }
    
    /**
     * Test Update Contact using Invalid phone address.
     *
     * @return void
     */
    public function testUpdateNonValidPhoneContact()
    {
        $contact_id = $this->createNewContact();

        $response = $this->call('PUT', "/contacts/{$contact_id}", [ 
            'name' => 'Hyller Bandeira Dutra', 
            'address' => 'Paschoal Bettoni, 4, 03627-220',
            'phone' => '(15) 99658-53',
            'email' => 'hyller.bandeira@gmail.com'
        ]);
    
        $this->assertEquals(400, $response->status());
    }

    /**
     * Test contact listing filtering by name.
     *
     * @return void
     */
    public function testListingContactsByName()
    {
        $response = $this->call('GET', '/contacts', [ 'name' => 'Hyller' ]);
    
        $this->assertEquals(200, $response->status());
    }
    
    /**
     * Test Update Valid Contact.
     *
     * @return void
     */
    public function testDeleteValidContact()
    {
        $contact_id = $this->createNewContact();
        
        $response = $this->call('DELETE', "/contacts/{$contact_id}", [ 
            'name' => 'Hyller Bandeira Dutra', 
            'address' => 'Paschoal Bettoni, 4, 03627-220',
            'phone' => '(15) 99658-5369',
            'email' => 'hyller.bandeira@gmail.com'
        ]);

        $this->assertEquals(200, $response->status());
    }
    
    /**
     * Test Update Valid Contact.
     *
     * @return void
     */
    public function testDeleteNonValidContact()
    {   
        $response = $this->call('DELETE', '/contacts/0', [ 
            'name' => 'Hyller Bandeira Dutra', 
            'address' => 'Paschoal Bettoni, 4, 03627-220',
            'phone' => '(15) 99658-5369',
            'email' => 'hyller.bandeira@gmail.com'
        ]);

        $this->assertEquals(404, $response->status());
    }
}

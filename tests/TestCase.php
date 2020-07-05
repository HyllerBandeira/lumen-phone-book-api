<?php

use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use Laravel\Lumen\Testing\DatabaseTransactions;

abstract class TestCase extends BaseTestCase
{
    use DatabaseTransactions;

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

    /**
     * Creates a new contact.
     *
     * @return int
     */
    public function createNewContact()
    {
        // Create a new resource
        $json_create_response = $this->json('POST', '/contacts', [ 
                'name' => 'Hyller Bandeira Dutra', 
                'address' => 'Paschoal Bettoni, 4, 03627-220',
                'phone' => '(15) 99658-5369',
                'email' => 'hyller.bandeira@gmail.com'
            ])->response
            ->getContent();

        $create_response = json_decode($json_create_response);
        return $create_response->contact_id;
    }
    
}

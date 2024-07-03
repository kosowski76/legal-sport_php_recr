<?php
namespace App\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EntryControllerTest extends WebTestCase
{
    public function testCreateEntry()
    {
        $client = static::createClient();
        $client->request('POST', '/entries', [], [], 
            ['CONTENT_TYPE' => 'application/json'], 
            json_encode([
                'name' => 'Test Entry',
                'category' => 'Test Category',
                'date' => (new \DateTime())->format('Y-m-d H:i:s'),
            ]));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
    }

    public function testGetEntry()
    {
        $client = static::createClient();
        $client->request('GET', '/entries/1');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testUpdateEntry()
    {
        $client = static::createClient();
        $client->request('PUT', '/entries/1', [], [],
            ['CONTENT_TYPE' => 'application/json'], json_encode([
                'name' => 'Updated Entry',
                'category' => 'Updated Category',
                'date' => (new \DateTime())->format('Y-m-d H:i:s'),
        ]));
        
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }


}

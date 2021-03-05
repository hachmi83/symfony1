<?php


namespace App\Tests\Controller;



use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Messenger\Transport\InMemoryTransport;

class MailControllerTest extends WebTestCase
{
    public function testAdd()
    {
      $client = static::createClient();
      $client->request('POST', '/1/add', [1]);

      $this->assertResponseIsSuccessful();
        /**
         * @var InMemoryTransport $transport
         */
      $transport = self::$container->get('messenger.transport.async_priority_high');

      $this->assertCount(1 ,$transport->get());
    }

}
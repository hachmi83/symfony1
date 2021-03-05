<?php


namespace App\Tests\Controller;



use App\DataFixtures\UserFixtures;
use App\Entity\User;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class MailControllerFunctionnalTest extends WebTestCase
{
    protected function setUp(): void
    {
       // $this->loadFixtures([UserFixtures::class]);
    }


    public function testIfUserAreListedOnHomePage()
    {

        $this->loadFixtures([UserFixtures::class]);
        
        $client = $this->makeClient();

        $crawler = $client->request('GET', '/');

        $this->assertStatusCode(200, $client);

        $table = $crawler->filter('.table-user');
        $this->assertCount(3,$table->filter('tbody tr'));
    }

    public function testIfDeleteBtnShow()
    {
        $fixtures = $this->loadFixtures([UserFixtures::class])->getReferenceRepository();

        $user0 = $fixtures->getReference("main_users_0");

        $client = $this->makeClient();
        $crawler = $client->request('GET', '/');

      //  var_dump($client->getResponse()->getContent());

        $selector = sprintf('#user-%s .js-user-delete', $user0->getId());

        $this->assertGreaterThan(0,$crawler->filter($selector)->count());
    }

    public function testFormNewSubmit()
    {

        $this->loadFixtures([UserFixtures::class]);

        $client = $this->makeClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/new');
        $this->assertStatusCode(200, $client);

        $form = $crawler->selectButton('Create')->form();
        $form['user_form[name]'] = 'hach';

        $client->submit($form);
        $this->assertStringContainsString('user created !', $client->getResponse()->getContent());

    }

}
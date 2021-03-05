<?php


namespace App\Tests\Services;


use App\Repository\UserRepository;
use App\Services\Traitements;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Mailer\MailerInterface;

class TraitementsTest extends TestCase
{

    /**
     * @var UserRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    public $userRepository;
    public $entityManager;
    public $mailer;
    /**
     * @var Traitements|\PHPUnit\Framework\MockObject\MockObject
     */
    public $traitement;

    public function setUp(): void
    {

        $this->cr
        $this->userRepository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->entityManager = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->mailer = $this->getMockBuilder(MailerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->traitement = $this->getMockBuilder(Traitements::class)
        ->disableOriginalConstructor()
        ->getMock();


    }

    public function testFortTestUseFalseReturn()
    {
        $this->
        $this->userRepository->method('findBy')->willReturn([]);
        $this->assertEquals(false,$this->traitement->fortTestUse());
    }

    public function testFortTestUseTrueReturn()
    {
        $this->userRepository
            ->expects($this->any())
            ->method('findBy')
            ->willReturn([1,2]);
       $this->assertEquals(false,$this->traitement->fortTestUse());
    }

}
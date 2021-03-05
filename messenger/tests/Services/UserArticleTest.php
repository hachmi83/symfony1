<?php


namespace App\Tests\Services;


use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\UserArticle;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;

class UserArticleTest extends TestCase
{

    public function testItCreateArticle(){

        /**
         * @var EntityManagerInterface|ObjectProphecy
         */
        $em = $this->prophesize(EntityManagerInterface::class);
        /**
         * @var UserRepository|ObjectProphecy
         */
        $userRepository = $this->prophesize(UserRepository::class);
        /**
         * @var MailerInterface|ObjectProphecy
         */
        $mailer = $this->prophesize(MailerInterface::class);
        /**
         * @var LoggerInterface|ObjectProphecy
         */
        $logger = $this->prophesize(LoggerInterface::class);

        $userRepository->find(Argument::type('integer'))->shouldBeCalled();
        $userRepository->find(Argument::type('integer'));
        $userRepository->find(Argument::type('integer'))->willReturn(new User());

        $em->persist(Argument::type(Article::class))
        ->shouldBeCalledTimes(3);

        $em->flush()->shouldBeCalled();

        $logger->info(Argument::type('string'))->shouldBeCalled();

        $userArticle = new UserArticle($mailer->reveal(), $em->reveal(), $logger->reveal(), $userRepository->reveal());
        $userArticle->createArticleForUser(3, 'fruit');


    }

}
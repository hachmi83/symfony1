<?php


namespace App\Services;


use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class UserArticle
{
    private $entityManager;
    private $logger;
    private $mailer;
    private $userRepository;

    public function __construct(MailerInterface $mailer,EntityManagerInterface $entityManager, LoggerInterface $logger, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->mailer = $mailer;
        $this->userRepository = $userRepository;
    }

    public function createArticleForUser(int $nbrArticle, string $name){

        /**
         * @var User
         */
        $user = $this->userRepository->find(1);
        for ($i = 0; $i<$nbrArticle ; $i++){
            $article = new Article();
            $article->setName($name.$i);
            $article->setDescription('description for '.$name);
            $article->setUser($user);
            $article->setUpdatedAt(new \DateTimeImmutable());

            $this->entityManager->persist($article);
        }
        $this->entityManager->flush();

        $this->logger->info(sprintf('%d articles was be added to database by %s',$nbrArticle,'hach'));

        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('ARTICLE ADDED')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);
    }
}
<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Traitements
{

    private $userRepository;
    private $entityManager;
    private $mailer;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager , MailerInterface $mailer)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    public function addPankaToImage()
    {
        sleep(5);

        return;
    }

    public function addForUser(User $user)
    {
        sleep(3);
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('ADD FOR USER')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);

        $user->setDate(new \DateTimeImmutable());
       $this->entityManager->flush();

        return;
    }

    public function minusForUser(User $user)
    {

        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('MINUS FOR USER')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);

        $user->setDate(new \DateTimeImmutable());
        $this->entityManager->flush();

        return;
    }

    public function deleteUserTraitement(User $user)
    {
        sleep(5);
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('USER DELETED')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);

        return;
    }

    public function updateUserTraitement(int $user)
    {
        sleep(5);
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('USER UPDATED')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);

        return;
    }

    public function fortTestUse(): bool
    {
        $listUser = $this->userRepository->findBy(['deleteUser' => false]);
        if (count($listUser) === 0) {
            return false;
        }
        return true;

    }

    public function testMethod(bool $true, array $array)
    {

        return true;
    }
}
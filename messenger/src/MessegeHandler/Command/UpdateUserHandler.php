<?php

namespace App\MessegeHandler\Command;

use App\Entity\User;
use App\Message\Event\UserUpdatedEvent;
use App\Message\Command\UpdateUser;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class UpdateUserHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;


    private $userRepository;
    private $entityManager;
    private $messageBus;
    private $eventBus;

    public function __construct( UserRepository $userRepository, EntityManagerInterface $entityManager, MessageBusInterface $eventBus)
    {

        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->eventBus = $eventBus;
    }


    public function __invoke(UpdateUser $event)
    {
        //sync
        /**
         * @var User $user
         */
        $user = $this->userRepository->find($event->getUserId());
        $updateBool = $user->getUpdateUser();
        $user->setUpdateUser(!$updateBool);
        $this->entityManager->flush();

        //async
        $this->eventBus->dispatch(new UserUpdatedEvent($user->getId()));


    }
}
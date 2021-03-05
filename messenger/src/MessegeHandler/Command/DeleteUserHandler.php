<?php

namespace App\MessegeHandler\Command;

use App\Entity\User;
use App\Message\Command\DeleteUserTraitement;
use App\Message\Command\DeleteUser;
use App\Message\Command\MinusToUser;
use App\Repository\UserRepository;
use App\Services\Traitements;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteUserHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private $traitements;
    private $userRepository;
    private $entityManager;
    private $messageBus;

    public function __construct(Traitements $traitements, UserRepository $userRepository, EntityManagerInterface $entityManager, MessageBusInterface $messageBus)
    {
        $this->traitements = $traitements;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->messageBus = $messageBus;
    }

    public function __invoke(DeleteUser $deleteUser)
    {
        $user = $this->userRepository->find($deleteUser->getUserId());


        if(!$user instanceof User){
            if($this->logger){
                $this->logger->alert(sprintf('attention no user with that id : %d !!', $deleteUser->getUserId()));
            }
        };

        $user->setDeleteUser(true);
        $this->entityManager->flush();


        $this->messageBus->dispatch(new DeleteUserTraitement($user->getId()));


    }
}
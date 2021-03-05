<?php

namespace App\MessegeHandler\Subscribers;

use App\Entity\User;
use App\Message\Command\DeleteUserTraitement;
use App\Message\Command\DeleteUser;
use App\Repository\UserRepository;
use App\Services\Traitements;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DeleteUserHandlerSub implements MessageSubscriberInterface, LoggerAwareInterface
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

    public static function getHandledMessages(): iterable
    {
        yield DeleteUser::class => [
            'method' => '__invoke',
            'priority' => 5
        ];

//        yield DeleteUser::class => [
//            'method' => '__invoke',
//            'priority' => 5
//        ];
    }


}
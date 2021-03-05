<?php

namespace App\MessegeHandler\Command;

use App\Entity\User;
use App\Message\Command\AddToUser;
use App\Repository\UserRepository;
use App\Services\Traitements;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddToUserHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private $traitements;
    private $userRepository;

    public function __construct(Traitements $traitements, UserRepository $userRepository)
    {
        $this->traitements = $traitements;
        $this->userRepository = $userRepository;
    }

    public function __invoke(AddToUser $addToUser)
    {
        $user = $this->userRepository->find($addToUser->getUserId());
        if(!$user instanceof User){
          if($this->logger){
              $this->logger->alert(sprintf('attention no user with that id : %d !!', $addToUser->getUserId()));
          }
        }

        $this->traitements->addForUser($user);
    }
}
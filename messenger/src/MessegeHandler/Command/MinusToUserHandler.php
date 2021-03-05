<?php

namespace App\MessegeHandler\Command;

use App\Entity\User;
use App\Message\Command\MinusToUser;
use App\Repository\UserRepository;
use App\Services\Traitements;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class MinusToUserHandler implements MessageHandlerInterface
{
    private $traitements;
    private $userRepository;

    public function __construct(Traitements $traitements, UserRepository $userRepository)
    {
        $this->traitements = $traitements;
        $this->userRepository = $userRepository;
    }

    public function __invoke(MinusToUser  $minusToUser)
    {
        $user = $this->userRepository->find($minusToUser->getUserId());
        if($user instanceof User){
            $this->traitements->minusForUser($user);
        };
    }
}
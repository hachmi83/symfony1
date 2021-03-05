<?php

namespace App\MessegeHandler\Command;

use App\Message\Command\DeleteUserTraitement;
use App\Repository\UserRepository;
use App\Services\Traitements;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteUserTraitementHandler implements MessageHandlerInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private $traitements;
    private $userRepository;

    public function __construct(Traitements $traitements, UserRepository $userRepository)
    {
        $this->traitements = $traitements;
        $this->userRepository = $userRepository;
    }

    public function __invoke(DeleteUserTraitement $deleteUserTraitement)
    {
        $user = $this->userRepository->find($deleteUserTraitement->getUserId());
        $this->traitements->deleteUserTraitement($user);

    }
}
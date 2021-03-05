<?php


namespace App\MessegeHandler\Query;


use App\Message\Query\GetTotalUserCount;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetTotalUserCountHandler implements MessageHandlerInterface
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetTotalUserCount $getTotalUserCount)
    {

        return count($this->userRepository->findBy(['deleteUser'=>false]));
    }

}
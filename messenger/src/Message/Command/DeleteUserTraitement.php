<?php


namespace App\Message\Command;


class DeleteUserTraitement
{
    private $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): int
    {
        return  $this->userId;
    }
}
<?php


namespace App\Message\Event;


class UserUpdatedEvent
{

    private $userId;

    /**
     * ImagePostUpdatedEvent constructor.
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }


}
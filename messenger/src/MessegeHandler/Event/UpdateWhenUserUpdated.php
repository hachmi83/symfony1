<?php


namespace App\MessegeHandler\Event;


use App\Message\Event\UserUpdatedEvent;
use App\Services\Traitements;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class UpdateWhenUserUpdated implements MessageHandlerInterface
{

    private $eventBus;
    private $traitements;

    public function __construct(Traitements $traitements,MessageBusInterface $eventBus)
    {

        $this->eventBus = $eventBus;
        $this->traitements = $traitements;
    }

    public function __invoke(UserUpdatedEvent $event)
    {

        $userId = $event->getUserId();
        $this->traitements->updateUserTraitement($userId);

    }

}
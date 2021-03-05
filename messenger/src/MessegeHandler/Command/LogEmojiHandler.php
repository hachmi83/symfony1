<?php


namespace App\MessegeHandler\Command;


use App\Message\Command\LogEmoji;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class LogEmojiHandler implements MessageHandlerInterface
{
    private static $emogi = [
        'Happy Emoji :)',
        'Sad Emogi :(',
        'Satisfait emogi ^^'
    ];
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(LogEmoji $logEmoji)
    {
        $emogiIndex = $logEmoji->getEmojiIndex();
        $emogi = self::$emogi[$emogiIndex] ?? self::$emogi[0];

        $this->logger->info('Important message ! the user is : '.$emogi);

    }

}
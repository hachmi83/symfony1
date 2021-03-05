<?php


namespace App\Messenger;


use App\Message\Command\LogEmoji;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Stamp\BusNameStamp;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class ExternalJsonMessengerSerializer implements SerializerInterface
{
    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        $headers = $encodedEnvelope['headers'];

        $data = \json_decode($body, true);
        if(null===$data){
            throw new MessageDecodingFailedException('Invalid JSON!');
        }

        if(!isset($data['emogi'])){
            throw new MessageDecodingFailedException('Missing EMOJI !');
        }

        if(!isset($headers['type'])){
            throw new MessageDecodingFailedException('Missing TYPE! ');
        }

        switch ($headers['type']){
            case 'emogi':
                return $this->createEmojiEnvelope($data);
            case 'delete_user':
                break;
        }

        throw new MessageDecodingFailedException(sprintf("Invalid type header %s",$headers["type"]));

    }

    public function encode(Envelope $envelope): array
    {
        throw new \Exception('Transport & serializer not means for sending messages');
    }

    /**
     * @param $data
     * @return Envelope
     */
    public function createEmojiEnvelope(array $data): Envelope
    {
        $message = new LogEmoji($data['emogi']);

        $envelope = new Envelope($message);
        // needed if u need to sent throught non default bus
        $envelope->with(new BusNameStamp('command.bus'));

        return $envelope;
    }


}
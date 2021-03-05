<?php


namespace App\Entity;

use App\Exception\NotAnimalException;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table()
 */
class Animal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    public const LARGE = 10;

    /**
     * @ORM\Column(type="integer")
     */
    private $length =0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDangenours;

    /**
     * @ORM\Column(type="string")
     */
    private $type;

    /**
     * Animal constructor.
     * @param int $length
     * @param $isDangenours
     */
    public function __construct(string $type = 'Unknown', bool $isDangenours = false)
    {
        $this->isDangenours = $isDangenours;
        $this->type= $type;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getIsDangenours()
    {
        return $this->isDangenours;
    }

    /**
     * @param mixed $isDangenours
     */
    public function setIsDangenours($isDangenours): void
    {
        $this->isDangenours = $isDangenours;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function throwExceptionForAnimal()
    {
        if ($this->length == 1 && $this->isDangenours === true) {
            throw new  NotAnimalException();
        }
    }


}
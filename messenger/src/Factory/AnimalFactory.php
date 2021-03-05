<?php


namespace App\Factory;


use App\Entity\Animal;

class AnimalFactory
{

    public function createLion(int $length): Animal
    {
        $lion = new Animal('Lion',true);
        $lion->setLength($length);

        return $lion;
    }

}
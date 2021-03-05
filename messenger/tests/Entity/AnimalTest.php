<?php


namespace App\Tests\Entity;


use App\Entity\Animal;
use PHPUnit\Framework\TestCase;

class AnimalTest extends TestCase
{

    public function testSetting(){

        $animal = new Animal();
        $this->assertSame(0,$animal->getLength());

        $animal->setLength(9);
        $this->assertSame(9,$animal->getLength());

    }
}
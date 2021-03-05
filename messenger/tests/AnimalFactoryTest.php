<?php


namespace App\Tests;


use App\Entity\Animal;
use App\Exception\NotAnimalException;
use App\Factory\AnimalFactory;
use PHPUnit\Framework\TestCase;

class AnimalFactoryTest extends TestCase
{
    /**
     * @var AnimalFactory
     */
    private $factory;

    public function setUp(): void
    {
        $this->factory = new AnimalFactory();
    }

    public function testLion()
    {
        $animal = $this->factory->createLion(5);
        $this->assertInstanceOf(Animal::class, $animal);
        $this->assertIsString('string', $animal->getType());
        $this->assertSame(5, $animal->getLength());
    }

    /**
    * @dataProvider getAnimals
     */
    public function testIsDangenours(int $length, bool $isDangenours)
    {
        $animal = $this->factory->createLion($length);
        if ($isDangenours) {
            $this->assertGreaterThan(Animal::LARGE, $animal->getLength());
        } else {
            $this->assertLessThan(Animal::LARGE, $animal->getLength());
        }
    }

    public function getAnimals()
    {
        return [
            [11, true],
            [3, false]
        ];
    }

    public function testException1()
    {
        $animal = $this->factory->createLion(1);
        $animal->setIsDangenours(true);
        $this->expectException(NotAnimalException::class);
        $animal->throwExceptionForAnimal();

    }

    public function testException2()
    {

        $animal = $this->factory->createLion(1);
        $animal->setIsDangenours(true);
        $this->expectExceptionMessage('Exception MTF !!');
        $animal->throwExceptionForAnimal();

    }

}
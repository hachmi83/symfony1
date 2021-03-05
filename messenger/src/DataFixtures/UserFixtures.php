<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends BaseFixture
{

    protected function loadData(ObjectManager $manager)
    {
        $this->newCreateMany(3,'main_users', function ($i) use ($manager){
            $user = new User();
            $user->setName($this->faker->firstName);
            $user->setDate(new \DateTimeImmutable());
            $manager->persist($user);

            return $user;

        });

        $manager->flush();
    }
}

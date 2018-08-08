<?php

namespace App\DataFixtures;

use App\Entity\Owner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class OwnerFixtures extends BaseFixtures
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Owner::class, 5, function(Owner $owner) use ($manager){
            $owner->setName($this->faker->name);
            $owner->setAddress($this->faker->address);
            $owner->setEmail($this->faker->email);
            $owner->setSlug($owner->getName().'-'.rand(1, 100));
            $owner->setTelephone($this->faker->phoneNumber);
        });

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Owner;
use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PropertyFixtures extends BaseFixtures
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Property::class, 10, function(Property $property) use ($manager){
            $property->setName($this->faker->name(). ' Incorporated');
            $property->setAddress($this->faker->address);
            $property->setOwner($this->getRandomReference(Owner::class));
        });
        $manager->flush();
    }

    public function getDependencies(){
        return [OwnerFixtures::class];
    }
}

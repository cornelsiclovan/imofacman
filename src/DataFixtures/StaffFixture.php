<?php

namespace App\DataFixtures;

use App\Entity\Staff;
use App\Entity\StaffType;
use Doctrine\Common\Persistence\ObjectManager;

class StaffFixture extends BaseFixtures
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Staff::class, 10, function(Staff $staff){
            $staff->setName($this->faker->name);
            $staff->setEmail($this->faker->email);
            $staff->setPassword('password');
            $staff->setStaffType($this->getRandomReference(StaffType::class));
        });

        $manager->flush();
    }

    public function getDependencies(){
        return [StaffATypeFixture::class];
    }
}

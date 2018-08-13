<?php

namespace App\DataFixtures;

use App\Entity\Staff;
use App\Entity\StaffType;
use App\Service\HashPasswordListener;
use Doctrine\Common\Persistence\ObjectManager;


class StaffFixture extends BaseFixtures
{
    private $hashPasswordListener;

    public function __construct(HashPasswordListener $hashPasswordListener)
    {
        $this->hashPasswordListener = $hashPasswordListener;
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Staff::class, 10, function(Staff $staff){
            $staff->setName($this->faker->name);
            $staff->setEmail($this->faker->email);
            $staff->setPlainPassword('password');
            $staff->setRoles(['ROLE_ADMIN']);
            $this->hashPasswordListener->encodePassword($staff);
            $staff->setStaffType($this->getRandomReference(StaffType::class));
        });

        $manager->flush();
    }

    public function getDependencies(){
        return [StaffATypeFixture::class];
    }
}

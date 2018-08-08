<?php

namespace App\DataFixtures;

use App\Entity\StaffType;
use Doctrine\Common\Persistence\ObjectManager;

class StaffATypeFixture extends BaseFixtures
{
    static $i = 0;
    private static $roles = ['Adminstrative', 'Management assist', 'Cleaning', 'Judicial', 'Maintenance'];
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(StaffType::class, 5, function(StaffType $staffType) use ($manager) {
            $staffType->setType(self::$roles[self::$i++]);
        });

        $manager->flush();
    }
}

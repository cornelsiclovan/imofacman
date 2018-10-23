<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ActivityType extends BaseFixtures
{
    static $i = 0;
    private static $activityTypes = ['Intern', 'Extern', 'IFM', 'Service Charge'];
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(\App\Entity\ActivityType::class, 4, function(\App\Entity\ActivityType $activityType) use ($manager){
            $activityType->setType(self::$activityTypes[self::$i++]);
        });


        $manager->flush();
    }
}

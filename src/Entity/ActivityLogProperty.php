<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 27.08.2018
 * Time: 14:29
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="activity_log_property")
 */
class ActivityLogProperty
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ActivityLog", inversedBy="property")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activityLog;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Property", inversedBy="activityLogs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $property;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getActivityLog()
    {
        return $this->activityLog;
    }

    /**
     * @param mixed $activityLog
     */
    public function setActivityLog($activityLog)
    {
        $this->activityLog = $activityLog;
    }



    /**
     * @return mixed
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * @param mixed $property
     */
    public function setProperty($property)
    {
        $this->property = $property;
    }
}
<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivityLogRepository")
 */
class ActivityLog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publishedAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Staff", inversedBy="activityLogs")
     */
    private $staff;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Owner", inversedBy="activityLogs")
     */
    private $owner;

    /**
     * @ORM\Column(type="boolean")
     */
    private $intern;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $log;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $details;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lunchBreak;

    public function __construct()
    {
        $this->staff = new ArrayCollection();
        $this->owner = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * @return Collection|Staff[]
     */
    public function getStaff(): Collection
    {
        return $this->staff;
    }

    public function addStaff(Staff $staff): self
    {
        if (!$this->staff->contains($staff)) {
            $this->staff[] = $staff;
        }

        return $this;
    }

    public function removeStaff(Staff $staff): self
    {
        if ($this->staff->contains($staff)) {
            $this->staff->removeElement($staff);
        }

        return $this;
    }

    /**
     * @return Collection|Owner[]
     */
    public function getOwner(): Collection
    {
        return $this->owner;
    }

    public function addOwner(Owner $owner): self
    {
        if (!$this->owner->contains($owner)) {
            $this->owner[] = $owner;
        }

        return $this;
    }

    public function removeOwner(Owner $owner): self
    {
        if ($this->owner->contains($owner)) {
            $this->owner->removeElement($owner);
        }

        return $this;
    }

    public function getIntern(): ?bool
    {
        return $this->intern;
    }

    public function setIntern(bool $intern): self
    {
        $this->intern = $intern;

        return $this;
    }

    public function getLog(): ?string
    {
        return $this->log;
    }

    public function setLog(string $log): self
    {
        $this->log = $log;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getLunchBreak(): ?string
    {
        return $this->lunchBreak;
    }

    public function setLunchBreak(string $lunchBreak): self
    {
        $this->lunchBreak = $lunchBreak;

        return $this;
    }
}

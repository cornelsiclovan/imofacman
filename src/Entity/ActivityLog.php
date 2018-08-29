<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank(groups={"for_owner_data_input"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Owner", inversedBy="activityLogs")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $owner;

    /**
     * @ORM\Column(type="boolean")
     */
    private $intern;

    /**
     * @Assert\NotBlank(groups={"for_owner_data_input", "for_property_data_input"})
     * @ORM\Column(type="string", length=255)
     */
    private $log;

    /**
     * @Assert\NotBlank(groups={"for_owner_data_input", "for_property_data_input"})
     * @Assert\Range(min=0, minMessage="Va rugam introduceti o valoare pozitiva")
     * @ORM\Column(type="float", length=10)
     */
    private $duration;

    /**
     * @Assert\NotBlank(groups={"for_owner_data_input", "for_property_data_input"})
     * @ORM\Column(type="string", length=255)
     */
    private $details;

    /**
     * @Assert\NotBlank(groups={"for_owner_data_input", "for_property_data_input"})
     * @ORM\Column(type="string", length=255)
     */
    private $lunchBreak;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Staff", inversedBy="activityLogs")
     */
    private $staff;

    /**
     * @Assert\NotBlank(groups={"for_owner_data_input", "for_property_data_input"})
     * @ORM\Column(type="date")
     */
    private $publishedAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Property", inversedBy="activityLogs")
     * @ORM\OrderBy({"name" = "ASC"})
     * @Assert\NotBlank(groups={"for_property_data_input"})
     */
    private $property;


    public function __construct()
    {
        $this->owner = new ArrayCollection();
        $this->property = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }



    /**
     * @Assert\Collection(
     *     fields={
                "0" = @Assert\NotBlank(groups={"for_owner_data_input"})
     *
*          },
     *     allowMissingFields=false,
     *     allowExtraFields=true,
     *     groups={"for_owner_data_input"}
     * )
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

    public function getDuration(): ?float
    {
        return $this->duration;
    }

    public function setDuration(float $duration): self
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

    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    public function setStaff(?Staff $staff): self
    {
        $this->staff = $staff;

        return $this;
    }

    public function __toString()
    {
        return $this->getStaff()->getName();
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt = null): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     *  * @Assert\Collection(
     *     fields={
                 "0" = @Assert\NotBlank(groups={"for_property_data_input"})
     *
     *          },
     *     allowMissingFields=false,
     *     allowExtraFields=true,
     *     groups={"for_property_data_input"}
     * )
     * @return Collection|Property[]
     */
    public function getProperty(): Collection
    {
        return $this->property;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->property->contains($property)) {
            $this->property[] = $property;
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->property->contains($property)) {
            $this->property->removeElement($property);
        }

        return $this;
    }

}

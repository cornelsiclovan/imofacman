<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StaffTypeRepository")
 */
class StaffType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Staff", mappedBy="staffType")
     */
    private $staff;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $addDataFor;

    public function __construct()
    {
        $this->staff = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
            $staff->setStaffType($this);
        }

        return $this;
    }

    public function removeStaff(Staff $staff): self
    {
        if ($this->staff->contains($staff)) {
            $this->staff->removeElement($staff);
            // set the owning side to null (unless already changed)
            if ($staff->getStaffType() === $this) {
                $staff->setStaffType(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return $this->type;
    }

    public function getAddDataFor(): ?string
    {
        return $this->addDataFor;
    }

    public function setAddDataFor(string $addDataFor): self
    {
        $this->addDataFor = $addDataFor;

        return $this;
    }
}

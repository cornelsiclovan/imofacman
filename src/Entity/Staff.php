<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StaffRepository")
 * @UniqueEntity(fields={"email"}, message="It looks like your already have an account!", groups={"registration", "staff_edit"})
 */
class Staff implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(groups={"registration", "staff_edit"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Assert\NotBlank(groups={"registration", "staff_edit"})
     * @Assert\Email()
     * @ORM\Column(name="email", type="string", length=50, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Assert\NotBlank(groups={"registration", "password_reset"})
     */
    private $plainPassword;

    /**
     * @Assert\NotBlank(groups={"registration", "staff_edit"})
     * @ORM\ManyToOne(targetEntity="App\Entity\StaffType", inversedBy="staff")
     */
    private $staffType;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ActivityLog", mappedBy="staff")
     */
    private $activityLogs;


    public function __construct()
    {
        $this->activityLogs = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getStaffType(): ?StaffType
    {
        return $this->staffType;
    }

    public function setStaffType(?StaffType $staffType): self
    {
        $this->staffType = $staffType;

        return $this;
    }


    public function __toString(){
        return $this->getName();
    }

    /**
     * @return Collection|ActivityLog[]
     */
    public function getActivityLogs(): Collection
    {
        return $this->activityLogs;
    }

    public function addActivityLog(ActivityLog $activityLog): self
    {
        if (!$this->activityLogs->contains($activityLog)) {
            $this->activityLogs[] = $activityLog;
            $activityLog->setStaff($this);
        }

        return $this;
    }

    public function removeActivityLog(ActivityLog $activityLog): self
    {
        if ($this->activityLogs->contains($activityLog)) {
            $this->activityLogs->removeElement($activityLog);
            // set the owning side to null (unless already changed)
            if ($activityLog->getStaff() === $this) {
                $activityLog->setStaff(null);
            }
        }

        return $this;
    }

    public function getRoles()
    {
        $roles = $this->roles;
        if(!in_array('ROLE_USER', $roles)){
            $roles[] = 'ROLE_USER';
        }

        return $roles;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt()
    {
    }

    public function getUsername()
    {
       return $this->email;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        //guarantees that the entity looks dirty to Doctrine
        //when changing the plainPassword
        $this->password = null;
    }


}

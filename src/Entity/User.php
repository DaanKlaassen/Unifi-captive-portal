<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="Users")
 * @ORM\HasLifecycleCallbacks
 */
#[ORM\Entity]
#[ORM\Table(name: 'Users')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private string $id;

    #[ORM\Column(type: 'string', length: 32)]
    private string $name;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $email;

    #[ORM\Column(type: 'date')]
    private \DateTime $createdAt;

    #[ORM\Column(type: 'date')]
    private \DateTime $updatedAt;

    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private Role $role;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: User_Device::class, cascade: ['persist', 'remove'])]
    private Collection $devices;

    #[ORM\Column(type: 'integer')]
    private int $maxDevices;

    #[ORM\Column(type: 'boolean')]
    private bool $acceptedTOU;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->devices = new ArrayCollection();
    }

    // Getters and Setters...

    #[ORM\PostLoad]
    public function onPostLoad()
    {
        // The ID should already be a Uuid object if it's properly mapped.
        // However, if you face issues, ensure it's correctly set.
        if (is_string($this->id)) {
            $this->id = Uuid::fromString($this->id);
        }
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function setRole(Role $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function addDevice(User_Device $device): self
    {
        if (!$this->devices->contains($device)) {
            $this->devices[] = $device;
            $device->setUser($this);
        }

        return $this;
    }

    public function removeDevice(User_Device $device): self
    {
        if ($this->devices->contains($device)) {
            $this->devices->removeElement($device);
            if ($device->getUser() === $this) {
                $device->setUser(null);
            }
        }

        return $this;
    }

    public function getMaxDevices(): int
    {
        return $this->maxDevices;
    }

    public function setMaxDevices(int $maxDevices): self
    {
        $this->maxDevices = $maxDevices;
        return $this;
    }

    public function getAcceptedTOU(): bool
    {
        return $this->acceptedTOU;
    }

    public function setAcceptedTOU(bool $acceptedTOU): self
    {
        $this->acceptedTOU = $acceptedTOU;
        return $this;
    }
}

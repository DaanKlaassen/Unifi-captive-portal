<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'Users')]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(type: 'string', length: 32)]
    private string $name;
    #[ORM\Column(type: 'string', length: 255)]
    private string $email;
    #[ORM\Column(type: 'integer')]
    private string $devices;
    #[ORM\Column(type: 'string', length: 16)]
    private string $role;
    #[ORM\Column(type: 'string', length: 255)]
    private string $mac;
    #[ORM\Column(type: 'string', length: 15)]
    private string $ipAddress;
    #[ORM\Column(type: 'date')]
    private \DateTime $createdAt;
    #[ORM\Column(type: 'date')]
    private \DateTime $updatedAt;

        // Getters and Setters

        public function getId(): ?int
        {
            return $this->id;
        }
    
        public function setName(string $name): self
        {
            $this->name = $name;
            return $this;
        }
    
        public function getName(): string
        {
            return $this->name;
        }
    
        public function setEmail(string $email): self
        {
            $this->email = $email;
            return $this;
        }
    
        public function getEmail(): string
        {
            return $this->email;
        }
    
        public function setDevices(int $devices): self
        {
            $this->devices = $devices;
            return $this;
        }
    
        public function getDevices(): int
        {
            return $this->devices;
        }
    
        public function setRole(string $role): self
        {
            $this->role = $role;
            return $this;
        }
    
        public function getRole(): string
        {
            return $this->role;
        }
    
        public function setMac(string $mac): self
        {
            $this->mac = $mac;
            return $this;
        }
    
        public function getMac(): string
        {
            return $this->mac;
        }
    
        public function setIpAddress(string $ipAddress): self
        {
            $this->ipAddress = $ipAddress;
            return $this;
        }
    
        public function getIpAddress(): string
        {
            return $this->ipAddress;
        }
    
        public function setCreatedAt(\DateTime $createdAt): self
        {
            $this->createdAt = $createdAt;
            return $this;
        }
    
        public function getCreatedAt(): \DateTime
        {
            return $this->createdAt;
        }
    
        public function setUpdatedAt(\DateTime $updatedAt): self
        {
            $this->updatedAt = $updatedAt;
            return $this;
        }
    
        public function getUpdatedAt(): \DateTime
        {
            return $this->updatedAt;
        }
}

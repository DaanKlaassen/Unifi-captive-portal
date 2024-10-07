<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity]
#[ORM\Table(name: 'UserDevices')]
class UserDevice
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private string|null $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $device_mac;

    #[ORM\Column(type: 'string', length: 15)]
    private string $device_ip;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'devices')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    // Getters and Setters

    public function __construct()
    {
        $this->id = Uuid::v4();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDeviceMac(): string
    {
        return $this->device_mac || '';
    }

    public function setDeviceMac(string $device_mac): self
    {
        $this->device_mac = $device_mac;
        return $this;
    }

    public function getDeviceIp(): string
    {
        return $this->device_ip || '';
    }

    public function setDeviceIp(string $device_ip): self
    {
        $this->device_ip = $device_ip;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }
}

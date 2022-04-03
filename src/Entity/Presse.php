<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Presse
 *
 * @ORM\Table(name="presse", indexes={@ORM\Index(name="FK2", columns={"userName"})})
 * @ORM\Entity
 */
class Presse
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="userName", type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var bool
     *
     * @ORM\Column(name="badgeAttribue", type="boolean", nullable=false)
     */
    private $badgeattribue = '0';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getBadgeattribue(): ?bool
    {
        return $this->badgeattribue;
    }

    public function setBadgeattribue(bool $badgeattribue): self
    {
        $this->badgeattribue = $badgeattribue;

        return $this;
    }


}

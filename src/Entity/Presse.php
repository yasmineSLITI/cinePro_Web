<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PublicationRepository;

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
     * @var bool
     *
     * @ORM\Column(name="badgeAttribue", type="boolean", nullable=false)
     */
    private $badgeattribue = '0';

    /**
     * @var \Compte
     *
     * @ORM\ManyToOne(targetEntity="Compte")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userName", referencedColumnName="userName")
     * })
     */
    private $username;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUsername(): ?Compte
    {
        return $this->username;
    }

    public function setUsername(?Compte $username): self
    {
        $this->username = $username;

        return $this;
    }
    public function __toString() {
        return (string) $this->getId();

    }
    


    

}

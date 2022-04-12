<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sponsor
 *
 * @ORM\Table(name="sponsor", indexes={@ORM\Index(name="FK4", columns={"userName"}), @ORM\Index(name="FK301", columns={"IdEv"})})
 * @ORM\Entity
 */
class Sponsor
{
    /**
     * @var int
     *
     * @ORM\Column(name="idSp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsp;

    /**
     * @var string
     *
     * @ORM\Column(name="Etat", type="string", length=20, nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="Specialite", type="string", length=50, nullable=false)
     */
    private $specialite;

    /**
     * @var \Evenement
     *
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdEv", referencedColumnName="IdEv")
     * })
     */
    private $idev;

    /**
     * @var \Compte
     *
     * @ORM\ManyToOne(targetEntity="Compte")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userName", referencedColumnName="userName")
     * })
     */
    private $username;

    public function getIdsp(): ?int
    {
        return $this->idsp;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getIdev(): ?Evenement
    {
        return $this->idev;
    }

    public function setIdev(?Evenement $idev): self
    {
        $this->idev = $idev;

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


}

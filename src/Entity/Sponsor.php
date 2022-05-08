<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Sponsor
 *
 * @ORM\Table(name="sponsor", indexes={@ORM\Index(name="FK4", columns={"userName"})})
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
     * @ORM\Column(name="Specialite", type="string", length=50, nullable=false)
     */
    private $specialite;

    /**
     * @var string
     *
     * @ORM\Column(name="userName", type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var \App\Entity\Demandedesponsoring 
     * @ORM\OneToMany(targetEntity="App\Entity\Realisateur",
     * mappedBy="idsp", cascade={"persist"}, orphanRemoval=true)
     * @Groups("demande")
     */
    private $demande;
    /**
     * @var \App\Entity\Evenement
     * @ORM\OneToMany(targetEntity="App\Entity\Evenement",
     * mappedBy="idsp", cascade={"persist"}, orphanRemoval=true)
     * @Groups("event")
     */
    private $idev;

    public function __construct()
    {
        $this->demande=new ArrayCollection();
    }
    public function getIdsp(): ?int
    {
        return $this->idsp;
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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getIdev(): ? Evenement
    {
        return $this->idev;
    }

    public function setIdev(?Evenement $idev): self
    {
        $this->idev = $idev;

        return $this;
    }
    public function getDemande(): ? Demandedesponsoring
    {
        return $this->demande;
    }

    public function setDemande(?Demandedesponsoring $demande): self
    {
        $this->demande = $demande;

        return $this;
    }

    

}

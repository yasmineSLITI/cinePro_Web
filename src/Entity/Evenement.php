<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="Fk1000000", columns={"NumRea"})})
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdEv", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idev =1 ;

    /**
     * @var string
     *
     * @ORM\Column(name="Etat", type="string", length=255, nullable=false)
     */
    private $etat = "En attente";

    /**
     * @var float
     *
     * @ORM\Column(name="Montant", type="float", precision=10, scale=0, nullable=false)
     */
    private $montant;

    /**
     * @var int
     *
     * @ORM\Column(name="Duree", type="integer", nullable=false)
     */
    private $duree;

    /**
     * @var float
     *
     * @ORM\Column(name="progret", type="float", precision=10, scale=0, nullable=false)
     */
    private $progret = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="nomEv", type="string", length=255, nullable=false)
     */
    private $nomev;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var \Realisateur
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Realisateur", inversedBy="evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="NumRea", referencedColumnName="NumRea")
     * })
     */
    private $numrea=null;
    
    /**
     * @var \App\Entity\Demandedesponsoring
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Demandedesponsoring", mappedBy="idev")
     * 
     */
    private $demande=null;
    public function getIdev(): ?int
    {
        return $this->idev;
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

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getProgret(): ?float
    {
        return $this->progret;
    }

    public function setProgret(float $progret): self
    {
        $this->progret = $progret;

        return $this;
    }

    public function getNomev(): ?string
    {
        return $this->nomev;
    }

    public function setNomev(string $nomev): self
    {
        $this->nomev = $nomev;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNumrea()
    {
        return $this->numrea;
    }

    public function setNumrea(?Realisateur $numrea): self
    {
        $this->numrea = $numrea;

        return $this;
    }


}

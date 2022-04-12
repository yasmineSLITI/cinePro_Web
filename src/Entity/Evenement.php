<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="FK40", columns={"NumRea"})})
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
    private $idev;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateDeb", type="date", nullable=false)
     */
    private $datedeb;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFin", type="date", nullable=false)
     */
    private $datefin;

    /**
     * @var string
     *
     * @ORM\Column(name="Etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var \Realisateur
     *
     * @ORM\ManyToOne(targetEntity="Realisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="NumRea", referencedColumnName="NumRea")
     * })
     */
    private $numrea;

    public function getIdev(): ?int
    {
        return $this->idev;
    }

    public function getDatedeb(): ?\DateTimeInterface
    {
        return $this->datedeb;
    }

    public function setDatedeb(\DateTimeInterface $datedeb): self
    {
        $this->datedeb = $datedeb;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->datefin;
    }

    public function setDatefin(\DateTimeInterface $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
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

    public function getNumrea(): ?Realisateur
    {
        return $this->numrea;
    }

    public function setNumrea(?Realisateur $numrea): self
    {
        $this->numrea = $numrea;

        return $this;
    }


}

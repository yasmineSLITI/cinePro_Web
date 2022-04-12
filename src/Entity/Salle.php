<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salle
 *
 * @ORM\Table(name="salle", indexes={@ORM\Index(name="FK303", columns={"idRes"})})
 * @ORM\Entity
 */
class Salle
{
    /**
     * @var int
     *
     * @ORM\Column(name="idSa", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsa;

    /**
     * @var int
     *
     * @ORM\Column(name="capacite", type="integer", nullable=false)
     */
    private $capacite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateDeDernierMain", type="date", nullable=false)
     */
    private $datedederniermain;

    /**
     * @var \Reservation
     *
     * @ORM\ManyToOne(targetEntity="Reservation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idRes", referencedColumnName="idRes")
     * })
     */
    private $idres;

    public function getIdsa(): ?int
    {
        return $this->idsa;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getDatedederniermain(): ?\DateTimeInterface
    {
        return $this->datedederniermain;
    }

    public function setDatedederniermain(\DateTimeInterface $datedederniermain): self
    {
        $this->datedederniermain = $datedederniermain;

        return $this;
    }

    public function getIdres(): ?Reservation
    {
        return $this->idres;
    }

    public function setIdres(?Reservation $idres): self
    {
        $this->idres = $idres;

        return $this;
    }


}

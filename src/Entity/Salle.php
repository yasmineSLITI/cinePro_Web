<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salle
 *
 * @ORM\Table(name="salle")
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
     * @ORM\Column(name="dateDeMaintenance", type="date", nullable=false)
     */
    private $datedemaintenance;

    /**
     * @var bool
     *
     * @ORM\Column(name="enMaintenance", type="boolean", nullable=false)
     */
    private $enmaintenance = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="nomSalle", type="string", length=255, nullable=false)
     */
    private $nomsalle;

    /**
     * @var string
     *
     * @ORM\Column(name="disponible", type="string", length=255, nullable=false, options={"default"="'En maintenance'"})
     */
    private $disponible = '\'En maintenance\'';

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

    public function getDatedemaintenance(): ?\DateTimeInterface
    {
        return $this->datedemaintenance;
    }

    public function setDatedemaintenance(\DateTimeInterface $datedemaintenance): self
    {
        $this->datedemaintenance = $datedemaintenance;

        return $this;
    }

    public function getEnmaintenance(): ?bool
    {
        return $this->enmaintenance;
    }

    public function setEnmaintenance(bool $enmaintenance): self
    {
        $this->enmaintenance = $enmaintenance;

        return $this;
    }

    public function getNomsalle(): ?string
    {
        return $this->nomsalle;
    }

    public function setNomsalle(string $nomsalle): self
    {
        $this->nomsalle = $nomsalle;

        return $this;
    }

    public function getDisponible(): ?string
    {
        return $this->disponible;
    }

    public function setDisponible(string $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }


}

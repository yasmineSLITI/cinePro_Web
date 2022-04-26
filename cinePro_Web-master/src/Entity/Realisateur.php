<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Realisateur
 *
 * @ORM\Table(name="realisateur", indexes={@ORM\Index(name="FK15", columns={"idC"})})
 * @ORM\Entity
 */
class Realisateur
{
    /**
     * @var int
     *
     * @ORM\Column(name="NumRea", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numrea;

    /**
     * @var int
     *
     * @ORM\Column(name="idC", type="integer", nullable=false)
     */
    private $idc;

    /**
     * @var string
     *
     * @ORM\Column(name="NomOrg", type="string", length=255, nullable=false)
     */
    private $nomorg;

    public function getNumrea(): ?int
    {
        return $this->numrea;
    }

    public function getIdc(): ?int
    {
        return $this->idc;
    }

    public function setIdc(int $idc): self
    {
        $this->idc = $idc;

        return $this;
    }

    public function getNomorg(): ?string
    {
        return $this->nomorg;
    }

    public function setNomorg(string $nomorg): self
    {
        $this->nomorg = $nomorg;

        return $this;
    }


}

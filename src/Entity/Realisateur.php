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
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idC", referencedColumnName="idC")
     * })
     */
    private $idc;

    public function getNumrea(): ?int
    {
        return $this->numrea;
    }

    public function getIdc(): ?Client
    {
        return $this->idc;
    }

    public function setIdc(?Client $idc): self
    {
        $this->idc = $idc;

        return $this;
    }


}

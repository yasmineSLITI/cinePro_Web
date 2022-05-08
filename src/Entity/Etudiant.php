<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etudiant
 *
 * @ORM\Table(name="etudiant", indexes={@ORM\Index(name="FK16", columns={"idC"})})
 * @ORM\Entity
 */
class Etudiant
{
    /**
     * @var string
     *
     * @ORM\Column(name="NumInscri", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numinscri;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idC", referencedColumnName="idC")
     * })
     */
    private $idc;

    public function getNuminscri(): ?string
    {
        return $this->numinscri;
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

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier", indexes={@ORM\Index(name="FK504", columns={"idB"})})
 * @ORM\Entity
 */
class Panier
{
    /**
     * @var int
     *
     * @ORM\Column(name="idPan", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpan;

    /**
     * @var int
     *
     * @ORM\Column(name="idP", type="integer", nullable=false)
     */
    private $idp;

    /**
     * @var int
     *
     * @ORM\Column(name="idC", type="integer", nullable=false)
     */
    private $idc;

    /**
     * @var \Billet
     *
     * @ORM\ManyToOne(targetEntity="Billet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idB", referencedColumnName="idB")
     * })
     */
    private $idb;

    public function getIdpan(): ?int
    {
        return $this->idpan;
    }

    public function getIdp(): ?int
    {
        return $this->idp;
    }

    public function setIdp(int $idp): self
    {
        $this->idp = $idp;

        return $this;
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

    public function getIdb(): ?Billet
    {
        return $this->idb;
    }

    public function setIdb(?Billet $idb): self
    {
        $this->idb = $idb;

        return $this;
    }


}

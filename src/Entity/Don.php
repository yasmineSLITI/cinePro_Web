<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Don
 *
 * @ORM\Table(name="don", indexes={@ORM\Index(name="Fk510", columns={"idClient"})})
 * @ORM\Entity
 */
class Don
{
    /**
     * @var int
     *
     * @ORM\Column(name="idDon", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iddon;

    /**
     * @var float
     *
     * @ORM\Column(name="Montant", type="float", precision=10, scale=0, nullable=false)
     */
    private $montant;

    /**
     * @var float
     *
     * @ORM\Column(name="TVA", type="float", precision=10, scale=0, nullable=false)
     */
    private $tva;

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idClient", referencedColumnName="idC")
     * })
     */
    private $idclient;

    public function getIddon(): ?int
    {
        return $this->iddon;
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

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getIdclient(): ?Client
    {
        return $this->idclient;
    }

    public function setIdclient(?Client $idclient): self
    {
        $this->idclient = $idclient;

        return $this;
    }


}

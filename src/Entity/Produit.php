<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="idP", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idp;

    /**
     * @var string
     *
     * @ORM\Column(name="NomPro", type="string", length=255, nullable=false)
     */
    private $nompro;

    /**
     * @var int
     *
     * @ORM\Column(name="QteStock", type="integer", nullable=false)
     */
    private $qtestock;

    /**
     * @var string
     *
     * @ORM\Column(name="Image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var float
     *
     * @ORM\Column(name="Prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    public function getIdp(): ?int
    {
        return $this->idp;
    }

    public function getNompro(): ?string
    {
        return $this->nompro;
    }

    public function setNompro(string $nompro): self
    {
        $this->nompro = $nompro;

        return $this;
    }

    public function getQtestock(): ?int
    {
        return $this->qtestock;
    }

    public function setQtestock(int $qtestock): self
    {
        $this->qtestock = $qtestock;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }


}

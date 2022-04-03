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
     * @ORM\Column(name="IDProduit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idproduit;

    /**
     * @var string
     *
     * @ORM\Column(name="Designation", type="string", length=255, nullable=false)
     */
    private $designation;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Image", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $image = 'NULL';

    /**
     * @var int
     *
     * @ORM\Column(name="QuantiteEnStock", type="integer", nullable=false)
     */
    private $quantiteenstock;

    /**
     * @var float
     *
     * @ORM\Column(name="prixAchatUnit", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixachatunit;

    /**
     * @var float
     *
     * @ORM\Column(name="prixVenteUnit", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixventeunit;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="StatusStock", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $statusstock = 'NULL';

    public function getIdproduit(): ?int
    {
        return $this->idproduit;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getQuantiteenstock(): ?int
    {
        return $this->quantiteenstock;
    }

    public function setQuantiteenstock(int $quantiteenstock): self
    {
        $this->quantiteenstock = $quantiteenstock;

        return $this;
    }

    public function getPrixachatunit(): ?float
    {
        return $this->prixachatunit;
    }

    public function setPrixachatunit(float $prixachatunit): self
    {
        $this->prixachatunit = $prixachatunit;

        return $this;
    }

    public function getPrixventeunit(): ?float
    {
        return $this->prixventeunit;
    }

    public function setPrixventeunit(float $prixventeunit): self
    {
        $this->prixventeunit = $prixventeunit;

        return $this;
    }

    public function getStatusstock(): ?bool
    {
        return $this->statusstock;
    }

    public function setStatusstock(?bool $statusstock): self
    {
        $this->statusstock = $statusstock;

        return $this;
    }


}

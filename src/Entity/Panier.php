<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier", indexes={@ORM\Index(name="fk", columns={"idClient"}), @ORM\Index(name="fk1", columns={"idBillet"}), @ORM\Index(name="FK2", columns={"idProduit"})})
 * @ORM\Entity(repositoryClass="App\Repository\PanierRepository")
 * 
 */
class Panier
{
    /**
     * @var int
     *
     * @ORM\Column(name="idPanier", type="integer", nullable=false, options={"default"="1"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idpanier = 1;

    /**
     * @var int
     *
     * @ORM\Column(name="idProduit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idproduit;

    /**
     * @var int
     *
     * @ORM\Column(name="idClient", type="integer", nullable=false)
     */
    private $idclient;

    /**
     * @var int
     *
     * @ORM\Column(name="idBillet", type="integer", nullable=false)
     */
    private $idbillet;

    /**
     * @var string
     *
     * @ORM\Column(name="nomPanier", type="string", length=255, nullable=false)
     */
    private $nompanier;

    /**
     * @var bool
     *
     * @ORM\Column(name="statusPanier", type="boolean", nullable=false)
     */
    private $statuspanier;

    /**
     * @var int
     *
     * @ORM\Column(name="Quantite", type="integer", nullable=false)
     */
    private $quantite;

    public function getIdpanier(): ?int
    {
        return $this->idpanier;
    }

    public function getIdproduit(): ?int
    {
        return $this->idproduit;
    }

    public function getIdclient(): ?int
    {
        return $this->idclient;
    }

    public function setIdclient(int $idclient): self
    {
        $this->idclient = $idclient;

        return $this;
    }

    public function getIdbillet(): ?int
    {
        return $this->idbillet;
    }

    public function setIdbillet(int $idbillet): self
    {
        $this->idbillet = $idbillet;

        return $this;
    }

    public function getNompanier(): ?string
    {
        return $this->nompanier;
    }

    public function setNompanier(string $nompanier): self
    {
        $this->nompanier = $nompanier;

        return $this;
    }

    public function getStatuspanier(): ?bool
    {
        return $this->statuspanier;
    }

    public function setStatuspanier(bool $statuspanier): self
    {
        $this->statuspanier = $statuspanier;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}

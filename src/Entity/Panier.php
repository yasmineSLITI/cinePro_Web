<?php

namespace App\Entity;
use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Panier
 *
 * @ORM\Table(name="panier", indexes={@ORM\Index(name="FK1", columns={"idProduit"}), @ORM\Index(name="FK3", columns={"idBillet"}), @ORM\Index(name="FK2", columns={"idClient"})})
 * @ORM\Entity(repositoryClass=PanierRepository::class)
 */
class Panier
{
    /**
     * @var int
     *
     * @ORM\Column(name="idPanier", type="integer", nullable=false, options={"default"="1"})
     * @Groups("post:read")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idpanier = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="nomPanier", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $nompanier;

    /**
     * @var bool
     *
     * @ORM\Column(name="statusPanier", type="boolean", nullable=false)
     * @Groups("post:read")
     */
    private $statuspanier;

    /**
     * @var int
     *
     * @ORM\Column(name="Quantite", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $quantite;

    /**
     * @var \Produit
     *
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProduit", referencedColumnName="IDProduit")
     * })
     * @Groups("post:read")
     */
    private $idproduit;

   /**
     * @var int
     *
     * @ORM\Column(name="idclient", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $idclient;

    /**
     * @var int
     *
     * @ORM\Column(name="idBillet", type="integer", nullable=false)
     * @Groups("post:read")
     */
    private $idbillet;

    public function getIdpanier(): ?int
    {
        return $this->idpanier;
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

    public function getIdproduit(): ?Produit
    {
        return $this->idproduit;
    }

    public function setIdproduit(?Produit $idproduit): self
    {
        $this->idproduit = $idproduit;

        return $this;
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


}

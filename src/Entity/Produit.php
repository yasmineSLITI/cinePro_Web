<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 * @UniqueEntity(
 *     fields={"designation"},
 *     message="Un Produit Ayant Cette Désignation est déja existant."
 * )
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
     * @ORM\Column(name="Designation", type="string", length=255, nullable=false,unique=true)
     * @Assert\NotBlank(message="Le Champ Désignation est obligatoire")
     */
    private $designation;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="text", length=65535, nullable=false)
     * @Assert\NotBlank(message="Le Champ Déscription est obligatoire")
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Image", type="string", length=255, nullable=true, options={"default"="NULL"})
     * @Assert\NotBlank(message="Le Champ Image est obligatoire")
     */
    private $image = 'NULL';

    /**
     * @var int
     *
     * @ORM\Column(name="QuantiteEnStock", type="integer", nullable=false)
     * @Assert\NotBlank(message="Le Champ Quantité En Stock est obligatoire")
     * @Assert\Type(type="integer")
     * @Assert\GreaterThan(0 , message="La Quantité En Stock Doit Etre Supérieur à Zéro.")
     */
    private $quantiteenstock;

    /**
     * @var float
     *
     * @ORM\Column(name="prixAchatUnit", type="float", precision=10, scale=0, nullable=false)
     * @Assert\NotBlank(message="Le Champ Prix Achat Unitaire est obligatoire")
     * @Assert\GreaterThan(0 , message="Le Prix D'Achat unitaire Doit Etre Supérieur à Zéro.")
     * @Assert\Regex(
     *     pattern="/([0-9]*[.])?[0-9]+/",
     *     match=true,
     *     message="Le Champ Déscription Ne Peut contenir Que Des Caractéres Alphanumériques"
     * )
     */
    private $prixachatunit;

    /**
     * @var float
     *
     * @ORM\Column(name="prixVenteUnit", type="float", precision=10, scale=0, nullable=false)
     * @Assert\NotBlank(message="Le Champ Prix Vente Unitaire est obligatoire")
     * * @Assert\GreaterThan(0 , message="Le Prix De Vente unitaire Doit Etre Supérieur à Zéro.")
     */
    private $prixventeunit;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="StatusStock", type="boolean", nullable=true, options={"default"="NULL"})
     */
    private $statusstock = 'NULL';

    /**
     * @ORM\OneToMany(targetEntity=Followingproduit::class, mappedBy="produit")
     */
    private $followings;

    public function __construct()
    {
        $this->followings = new ArrayCollection();
    }


    public function getIdproduit(): ?int
    {
        return $this->idproduit;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation = null): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description = null): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image = null): self
    {
        $this->image = $image;

        return $this;
    }

    public function getQuantiteenstock(): ?int
    {
        return $this->quantiteenstock;
    }

    public function setQuantiteenstock(int $quantiteenstock = null): self
    {
        $this->quantiteenstock = $quantiteenstock;

        return $this;
    }

    public function getPrixachatunit(): ?float
    {
        return $this->prixachatunit;
    }

    public function setPrixachatunit(float $prixachatunit = null): self
    {
        $this->prixachatunit = $prixachatunit;

        return $this;
    }

    public function getPrixventeunit(): ?float
    {
        return $this->prixventeunit;
    }

    public function setPrixventeunit(float $prixventeunit = null): self
    {
        $this->prixventeunit = $prixventeunit;

        return $this;
    }

    public function getStatusstock(): ?bool
    {
        return $this->statusstock;
    }

    public function setStatusstock(?bool $statusstock = null): self
    {
        $this->statusstock = $statusstock;

        return $this;
    }

    /**
     * @return Collection<int, Followingproduit>
     */
    public function getFollowings(): Collection
    {
        return $this->followings;
    }

    public function addFollowing(Followingproduit $following): self
    {
        if (!$this->followings->contains($following)) {
            $this->followings[] = $following;
            $following->setProduit($this);
        }

        return $this;
    }

    public function removeFollowing(Followingproduit $following): self
    {
        if ($this->followings->removeElement($following)) {
            // set the owning side to null (unless already changed)
            if ($following->getProduit() === $this) {
                $following->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return boolean
     */

    public function isFollowedByUser($client): bool
    {

        foreach ($this->followings as $following) {
            if ($following->getClient() === $client) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return boolean
     */

    public function isLikedByUser($idClient): bool
    {

        foreach ($this->followings as $following) {
            if ($following->getClient()->getIdClient() === $idClient) {
                return true;
            }
        }

        return false;
    }
}

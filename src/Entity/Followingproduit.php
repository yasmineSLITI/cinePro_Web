<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FollowingproduitRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=FollowingproduitRepository::class)
 */
class Followingproduit
{
    /**
     * @var int
     * 
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("followingProduit")
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="followings")
     * @ORM\JoinColumn(name="IDProduit", referencedColumnName="IDProduit")
     * @Groups("followingProduit")
     */
    public $produit;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="followings")
     * @ORM\JoinColumn(name="idClient", referencedColumnName="idClient")
     * @Groups("followingProduit")
     */
    public $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}

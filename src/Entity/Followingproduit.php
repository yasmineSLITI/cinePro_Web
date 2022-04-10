<?php

namespace App\Entity;

use App\Repository\FollowingproduitRepository;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="followings")
     * @ORM\JoinColumn(name="IDProduit", referencedColumnName="IDProduit")
     */
    private $produit;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="followings")
     * @ORM\JoinColumn(name="idClient", referencedColumnName="idClient")
     */
    private $client;

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

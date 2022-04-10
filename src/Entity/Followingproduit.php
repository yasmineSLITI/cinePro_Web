<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Followingproduit
 *
 * @ORM\Table(name="followingproduit", indexes={@ORM\Index(name="fk", columns={"idClient"}), @ORM\Index(name="FK2", columns={"IDProduit"})})
 * @ORM\Entity
 */
class Followingproduit
{
    /**
     * @var int
     * 
     * @ORM\Column(name="IDProduit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idproduit;

    /**
     * @var int
     *
     * @ORM\Column(name="idClient", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idclient;

    public function getIdproduit(): ?int
    {
        return $this->idproduit;
    }

    public function getIdclient(): ?int
    {
        return $this->idclient;
    }


}

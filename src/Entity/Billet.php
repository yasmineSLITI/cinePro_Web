<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Billet
 *
 * @ORM\Table(name="billet", indexes={@ORM\Index(name="FK_IDResBillet", columns={"idReservation"}), @ORM\Index(name="FK_IDClientBillet", columns={"idClient"})})
 * @ORM\Entity
 */
class Billet
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDBillet", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idbillet;

    /**
     * @var string
     *
     * @ORM\Column(name="categorieBillet", type="string", length=255, nullable=false)
     */
    private $categoriebillet;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_place", type="integer", nullable=false)
     */
    private $nbPlace;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $createdOn = 'current_timestamp()';

    /**
     * @var bool
     *
     * @ORM\Column(name="archived", type="boolean", nullable=false)
     */
    private $archived;

    /**
     * @var int
     *
     * @ORM\Column(name="idReservation", type="integer", nullable=false)
     */
    private $idreservation;

    /**
     * @var int
     *
     * @ORM\Column(name="idClient", type="integer", nullable=false)
     */
    private $idclient;

    public function getIdbillet(): ?int
    {
        return $this->idbillet;
    }

    public function getCategoriebillet(): ?string
    {
        return $this->categoriebillet;
    }

    public function setCategoriebillet(string $categoriebillet): self
    {
        $this->categoriebillet = $categoriebillet;

        return $this;
    }

    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    public function setNbPlace(int $nbPlace): self
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    public function getCreatedOn(): ?\DateTimeInterface
    {
        return $this->createdOn;
    }

    public function setCreatedOn(\DateTimeInterface $createdOn): self
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    public function getIdreservation(): ?int
    {
        return $this->idreservation;
    }

    public function setIdreservation(int $idreservation): self
    {
        $this->idreservation = $idreservation;

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


}

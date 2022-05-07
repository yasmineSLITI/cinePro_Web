<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Billet
 *
 * @ORM\Table(name="billet", indexes={@ORM\Index(name="FK_IDResBillet", columns={"idReservation"}), @ORM\Index(name="FK_IDClientBillet", columns={"idClient"})})
 * @ORM\Entity(repositoryClass="App\Repository\BilletRepository")
 */
class Billet
{
    /**
     * @var int
     *
     * @ORM\Column(name="IDBillet", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("api:billet")
     */
    private $idbillet;

    /**
     * @var string
     *
     * @ORM\Column(name="categorieBillet", type="string", length=255, nullable=false)
     * @Groups("api:billet")
     */
    private $categoriebillet;

    /**
     * @var int
     * @Assert\NotBlank(message="Le Champ Nombre De Place est obligatoire")
     * @Assert\Type(type="integer")
     * @Assert\GreaterThan(0 , message="Le Champ Nombre De Place Doit Etre Supérieur ou égale à 0.")
     * @ORM\Column(name="nb_place", type="integer", nullable=false)
     * @Groups("api:billet")
     */
    private $nbPlace;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     * @Groups("api:billet")
     */
    private $createdOn = 'current_timestamp()';

    /**
     * @var bool
     *
     * @ORM\Column(name="archived", type="boolean", nullable=false)
     * @Groups("api:billet")
     */
    private $archived;

    /**
     * @var int
     *
     * @ORM\Column(name="idReservation", type="integer", nullable=false)
     * @Groups("api:billet")
     */
    private $idreservation;

    /**
     * @var int
     *
     * @ORM\Column(name="idClient", type="integer", nullable=false)
     * @Groups("api:billet")
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

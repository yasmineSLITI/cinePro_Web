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
     * @ORM\Column(name="idB", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idb;

    /**
     * @var int
     *
     * @ORM\Column(name="nbChaiseAdulte", type="integer", nullable=false)
     */
    private $nbchaiseadulte = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="nbChaiseEnfant", type="integer", nullable=false)
     */
    private $nbchaiseenfant = '0';


    /**
     * @var \DateTime
     *

     * @ORM\Column(name="created_on", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     * @Groups("api:billet")
     */
    private $createdOn = 'current_timestamp()';

/** 
     * @ORM\Column(name="DateCrea", type="date", nullable=false, options={"default"="current_timestamp()"})
     */
    private $datecrea = 'current_timestamp()';

    /**
     * @var float
     *
     * @ORM\Column(name="PrixAdulte", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixadulte;

    /**
     * @var float
     *
     * @ORM\Column(name="PrixEnfant", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixenfant;


    /**
     * @var bool
     *

     * @ORM\Column(name="archived", type="boolean", nullable=false)
     * @Groups("api:billet")
     */
    private $archived;
/** 
     * @ORM\Column(name="Archive", type="boolean", nullable=false)
     */
    private $archive;

    /**
     * @var string
     *
     * @ORM\Column(name="Statut", type="string", length=255, nullable=false)
     */
    private $statut;


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
        $this->categoriebillet = $categoriebillet;}

/** 
     * @ORM\Column(name="idRes", type="integer", nullable=false)
     */
    private $idres;

    public function getIdb(): ?int
    {
        return $this->idb;
    }

    public function getNbchaiseadulte(): ?int
    {
        return $this->nbchaiseadulte;
    }

    public function setNbchaiseadulte(int $nbchaiseadulte): self
    {
        $this->nbchaiseadulte = $nbchaiseadulte;


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

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getIdres(): ?int
    {
        return $this->idres;
    }

    public function setIdres(int $idres): self
    {
        $this->idres = $idres;

        return $this;
    }



}

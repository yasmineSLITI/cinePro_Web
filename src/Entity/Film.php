<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Film
 *
 * @ORM\Table(name="film", indexes={@ORM\Index(name="FK400", columns={"NumRea"})})
 * @ORM\Entity
 * 
 */
class Film
{
    /**
     * @var int
     *
     * @ORM\Column(name="idF", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $idf;

    /**
     * @var string
     *@Assert\Length(min=5,max=255)
     * @ORM\Column(name="nomF", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $nomf;

    /**
     * @var string
     *
     * @ORM\Column(name="Genre", type="string", length=255, nullable=false)
     * @Assert\NotNull(message="ne doit étre pas null")
     * @Groups("post:read")
     */
    private $genre;

    /**
     * @var bool
     *
     * @ORM\Column(name="Archive", type="boolean", nullable=false)
     * @Groups("post:read")
     */
    private $archive = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="EtatAcc", type="string", length=255, nullable=false, options={"default"="'en attente'"})
     * @Groups("post:read")
     */
    private $etatacc = '\'en attente\'';

    /**
     * @var string
     *
     
     * @ORM\Column(name="Image", type="string", length=255, nullable=false)
     * @Groups("post:read")
     */
    private $image;

    /**
     * @var string
     * @Assert\Length(min=10,max=255)
     *@Assert\NotBlank(message="Doit étre remplis")
     * @ORM\Column(name="Description", type="string", length=255, nullable=false)
     * @Groups("post:read")
     * 
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDispo", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     * @Groups("post:read")
     */
    private $datedispo;

    /**
     * @var int
     *
     * @ORM\Column(name="duree", type="integer", nullable=false)
     * @Assert\Range(min=45,max=250)
     * @Groups("post:read")
     */
    private $duree;

    /**
     * @var \Realisateur
     *
     * @ORM\ManyToOne(targetEntity="Realisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="NumRea", referencedColumnName="NumRea")
     * 
     * })
     * @Groups("post:read")
     */
    private $numrea;

    public function getIdf(): ?int
    {
        return $this->idf;
    }

    public function getNomf(): ?string
    {
        return $this->nomf;
    }

    public function setNomf(string $nomf): self
    {
        $this->nomf = $nomf;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

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

    public function getEtatacc(): ?string
    {
        return $this->etatacc;
    }

    public function setEtatacc(string $etatacc): self
    {
        $this->etatacc = $etatacc;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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


    public function getDatedispo(): ?\dateTimeInterface
    {
        return $this->datedispo;
    }


    public function setDatedispo(\DateTimeInterface $datedispo): self
    {
        $date = new \DateTime();
        $this->datedispo = $date->getDatedispo();
        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getNumrea(): ?Realisateur
    {
        return $this->numrea;
    }

    public function setNumrea(?Realisateur $numrea): self
    {
        $this->numrea = $numrea;

        return $this;
    }
    public function __toString()
    {
        return $this->idf;
    }
}

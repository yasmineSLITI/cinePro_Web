<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation", indexes={@ORM\Index(name="fk1200", columns={"idEv"}), @ORM\Index(name="fk9000", columns={"idSa"}), @ORM\Index(name="fk1000", columns={"idF"})})
 * @ORM\Entity
 */
class Reservation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idRes", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("post:read")
     */
    private $idres;

    /**
     * @var string
     *
     * @ORM\Column(name="Categorie", type="string", length=255, nullable=false)
     *
     * 
     * @Assert\Choice({"Film", "Evénement"})
     * @Groups("post:read")
     *
     *
     * 
     */

    private $categorie;

    /**
     * @var int
     *
     * @ORM\Column(name="NbPlace", type="integer", nullable=false)
     
     * @Assert\Positive(
     * message="le nombre de place doit etre positive"
     * )
     *  @Groups("post:read")
     */

    private $nbplace;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DateDeb", type="string", length=255, nullable=true, options={"default"=""})
     * 
     * 
     * @Assert\NotNull(message="ne doit étre pas null")
     * @Groups("post:read")
     */
    private $datedeb = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="DateFin", type="string", length=255, nullable=true, options={"default"=""})
     * * @Assert\NotNull(message="ne doit étre pas null")
     * @Groups("post:read")
     */
    private $datefin = '';

    /**
     * @var \Evenement
     *
     * @ORM\ManyToOne(targetEntity="Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEv", referencedColumnName="IdEv",nullable=true)
     * })
     * @Groups("post:read")
     */
    private $idev;

    /**
     * @var \Film
     *
     * @ORM\ManyToOne(targetEntity="Film")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idF", referencedColumnName="idF")
     * @Groups("post:read")
     * })
     */
    private $idf;

    /**
     * @var \Salle
     *
     * @ORM\ManyToOne(targetEntity="Salle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idSa", referencedColumnName="idSa")
     * @Groups("post:read")
     * })
     */
    private $idsa;

    public function getIdres(): ?int
    {
        return $this->idres;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getNbplace(): ?int
    {
        return $this->nbplace;
    }

    public function setNbplace(int $nbplace): self
    {
        $this->nbplace = $nbplace;

        return $this;
    }

    public function getDatedeb(): ?string
    {
        return $this->datedeb;
    }

    public function setDatedeb(?string $datedeb): self
    {
        $this->datedeb = $datedeb;

        return $this;
    }

    public function getDatefin(): ?string
    {
        return $this->datefin;
    }

    public function setDatefin(?string $datefin): self
    {
        $this->datefin = $datefin;

        return $this;
    }

    public function getIdev(): ?Evenement
    {
        return $this->idev;
    }

    public function setIdev(?Evenement $idev): self
    {
        $this->idev = $idev;

        return $this;
    }

    public function getIdf(): ?Film
    {
        return $this->idf;
    }

    public function setIdf(?Film $idf): self
    {
        $this->idf = $idf;

        return $this;
    }

    public function getIdsa(): ?Salle
    {
        return $this->idsa;
    }

    public function setIdsa(?Salle $idsa): self
    {
        $this->idsa = $idsa;

        return $this;
    }
}

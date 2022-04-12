<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avis
 *
 * @ORM\Table(name="avis", indexes={@ORM\Index(name="FK306", columns={"idC"}), @ORM\Index(name="FK307", columns={"idF"})})
 * @ORM\Entity
 */
class Avis
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdAvis", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idavis;

    /**
     * @var int
     *
     * @ORM\Column(name="idC", type="integer", nullable=false)
     */
    private $idc;

    /**
     * @var int
     *
     * @ORM\Column(name="idF", type="integer", nullable=false)
     */
    private $idf;

    /**
     * @var float
     *
     * @ORM\Column(name="nbEtoile", type="float", precision=10, scale=0, nullable=false)
     */
    private $nbetoile;

    /**
     * @var string
     *
     * @ORM\Column(name="Commentaire", type="string", length=255, nullable=false)
     */
    private $commentaire;

    /**
     * @var float
     *
     * @ORM\Column(name="MoyenneAvis", type="float", precision=10, scale=0, nullable=false)
     */
    private $moyenneavis;

    public function getIdavis(): ?int
    {
        return $this->idavis;
    }

    public function getIdc(): ?int
    {
        return $this->idc;
    }

    public function setIdc(int $idc): self
    {
        $this->idc = $idc;

        return $this;
    }

    public function getIdf(): ?int
    {
        return $this->idf;
    }

    public function setIdf(int $idf): self
    {
        $this->idf = $idf;

        return $this;
    }

    public function getNbetoile(): ?float
    {
        return $this->nbetoile;
    }

    public function setNbetoile(float $nbetoile): self
    {
        $this->nbetoile = $nbetoile;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getMoyenneavis(): ?float
    {
        return $this->moyenneavis;
    }

    public function setMoyenneavis(float $moyenneavis): self
    {
        $this->moyenneavis = $moyenneavis;

        return $this;
    }


}

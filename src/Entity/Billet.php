<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Billet
 *
 * @ORM\Table(name="billet")
 * @ORM\Entity
 */
class Billet
{
    /**
     * @var int
     *
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

    public function getNbchaiseenfant(): ?int
    {
        return $this->nbchaiseenfant;
    }

    public function setNbchaiseenfant(int $nbchaiseenfant): self
    {
        $this->nbchaiseenfant = $nbchaiseenfant;

        return $this;
    }

    public function getDatecrea(): ?\DateTimeInterface
    {
        return $this->datecrea;
    }

    public function setDatecrea(\DateTimeInterface $datecrea): self
    {
        $this->datecrea = $datecrea;

        return $this;
    }

    public function getPrixadulte(): ?float
    {
        return $this->prixadulte;
    }

    public function setPrixadulte(float $prixadulte): self
    {
        $this->prixadulte = $prixadulte;

        return $this;
    }

    public function getPrixenfant(): ?float
    {
        return $this->prixenfant;
    }

    public function setPrixenfant(float $prixenfant): self
    {
        $this->prixenfant = $prixenfant;

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

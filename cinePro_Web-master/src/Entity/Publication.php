<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Publication
 *
 * @ORM\Table(name="publication", indexes={@ORM\Index(name="FK512", columns={"idPresse"})})
 * @ORM\Entity
 */
class Publication
{
    /**
     * @var int
     *
     * @ORM\Column(name="idPub", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpub;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="imgPub", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $imgpub = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="txtPub", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $txtpub = 'NULL';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreationPub", type="datetime", nullable=false)
     */
    private $datecreationpub ;

    /**
     * @var int
     *
     * @ORM\Column(name="idPresse", type="integer", nullable=false)
     */
    private $idpresse;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="archive", type="boolean", nullable=true)
     */
    private $archive = '0';

    public function getIdpub(): ?int
    {
        return $this->idpub;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getImgpub(): ?string
    {
        return $this->imgpub;
    }

    public function setImgpub(?string $imgpub): self
    {
        $this->imgpub = $imgpub;

        return $this;
    }

    public function getTxtpub(): ?string
    {
        return $this->txtpub;
    }

    public function setTxtpub(?string $txtpub): self
    {
        $this->txtpub = $txtpub;

        return $this;
    }

    public function getDatecreationpub(): ?\DateTimeInterface
    {
        return $this->datecreationpub;
    }

    public function setDatecreationpub(\DateTimeInterface $datecreationpub): self
    {
        $this->datecreationpub = $datecreationpub;

        return $this;
    }

    public function getIdpresse(): ?int
    {
        return $this->idpresse;
    }

    public function setIdpresse(int $idpresse): self
    {
        $this->idpresse = $idpresse;

        return $this;
    }

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(?bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }


}

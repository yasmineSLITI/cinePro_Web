<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\DateTimeType;
use App\Repository\PublicationRepository;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Presse;

/**
 * Publication
 *
 * @ORM\Table(name="publication", indexes={@ORM\Index(name="FK512", columns={"idPresse"})})
 * @ORM\Entity(repositoryClass = PublicationRepository::class)
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
     *@Assert\NotBlank(message="Le titre de la publication est requise, veuillez l'ajouter pour continuer")
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *@Assert\NotBlank(message="L'image de la publication est requise, veuillez l'ajouter pour continuer")
     * @ORM\Column(name="imgPub", type="string", length=255, nullable=false)
     */
    private $imgpub;

    /**
     * @var string|null
     *@Assert\NotBlank(message="La description de la publication est requise, veuillez l'ajouter pour continuer")
     * @ORM\Column(name="txtPub", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $txtpub;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreationPub", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $datecreationpub ;
     /**
 * @ORM\PreUpdate
 * @throws \Exception
 */
public function setDatecreationpub(\DateTimeInterface $datecreationpub): self
{
    $date = new \DateTime();
    $this->datecreationpub = $date->getDatecreationpub();
    return $this;
} 

    /**
     * @var bool|null
     *
     * @ORM\Column(name="archive", type="boolean", nullable=true)
     */
    private $archive = '0';

    /**
     * @var \Presse
     *
     * @ORM\ManyToOne(targetEntity="Presse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPresse", referencedColumnName="id")
     * })
     */
    private $idpresse =1 ;

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

    public function setImgpub(string $imgpub): self
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

    

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(?bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function getIdpresse(): ?Presse
    {
        return $this->idpresse;
    }

    public function setIdpresse(?Presse $idpresse): self
    {
        $this->idpresse = $idpresse;

        return $this;
    }


}

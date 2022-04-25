<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\CssSelector\Parser\Reader;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="Fk1000000", columns={"NumRea"})})
 * @ORM\Entity
 */
class Evenement
{
    /**
     * @var int
     *
     * @ORM\Column(name="IdEv", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idev  ;

    /**
     * @var string
     *
     * @ORM\Column(name="Etat", type="string", length=255, nullable=false)
     */
    private $etat = "En attente";

    /**
     * @var float
     *
     * @ORM\Column(name="Montant", type="float", precision=10, scale=0, nullable=false)
     * @Assert\GreaterThanOrEqual(value=5000,message="LE montant minimale est égale à 5000 ! ")
     */
    private $montant;

    /**
     * @var int
     *
     * @ORM\Column(name="Duree", type="integer", nullable=false)
     *@Assert\GreaterThanOrEqual(value=45 , message="La durée minimale d'un évenement est de 45 minutes !")
     *   
     */
    private $duree;

    /**
     * @var float
     *
     * @ORM\Column(name="progret", type="float", precision=10, scale=0, nullable=false)
     */
    private $progret = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="nomEv", type="string", length=255, nullable=false)
     *  @Assert\NotBlank(message = "Il parait que vous-avez oublié(e) de saisir le nom de l'événement ! ")
     */
    private $nomev;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var \Realisateur
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Realisateur", inversedBy="evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="NumRea", referencedColumnName="NumRea")
     * })
     */
    private $numrea;
    
    /**
     * @var \App\Entity\Demandedesponsoring
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Demandedesponsoring", mappedBy="idev")
     * 
     */
    private $demande;

    public function __construct()
    {
        $this->demnuande = new ArrayCollection();
    }

    public function getIdev(): ?int
    {
        return $this->idev;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

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

    public function getProgret(): ?float
    {
        return $this->progret;
    }

    public function setProgret(float $progret): self
    {
        $this->progret = $progret;

        return $this;
    }

    public function getNomev(): ?string
    {
        return $this->nomev;
    }

    public function setNomev(string $nomev): self
    {
        $this->nomev = $nomev;

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

    public function getNumrea()
    {
        return $this->numrea;
    }

    public function setNumrea(?Realisateur $numrea): self
    {
        $this->numrea = $numrea;

        return $this;
    }

    /**
     * @return Collection<int, Demandedesponsoring>
     */
    public function getDemande(): ?Demandedesponsoring
    {
        return $this->demande;
    }

    /*public function addDemande(Demandedesponsoring $demande): self
    {
        if (!$this->demande->contains($demande)) {
            $this->demande[] = $demande;
            $demande->setIdev($this);
        }

        return $this;
    }

    public function removeDemande(Demandedesponsoring $demande): self
    {
        if ($this->demande->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getIdev() === $this) {
                $demande->setIdev(null);
            }
        }

        return $this;
    }*/

    
    


}

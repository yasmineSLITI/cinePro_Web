<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Demandedesponsoring
 *
 * @ORM\Table(name="demandedesponsoring", indexes={@ORM\Index(name="fk7745566", columns={"idSp"}), @ORM\Index(name="fk7899", columns={"idEv"})})
 * @ORM\Entity
 */
class Demandedesponsoring
{
    /**
     * @var int
     *
     * @ORM\Column(name="idDemande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("demande")
     */
    private $iddemande;

    /**
     * @var \App\Entity\Evenement
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Evenement", inversedBy="demande")
     * @ORM\JoinColumns({
     *  
     *   @ORM\JoinColumn(name="IdEv", referencedColumnName="IdEv")
     * })
     */
    private $idev ;

    /**
     * @var \App\Entity\Sponsor
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Sponsor", inversedBy="demande")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="idSp", referencedColumnName="idSp")
     * })
     */
    private $idsp;

    /**
     * @var string
     *
     * @ORM\Column(name="etatAccept", type="string", length=255, nullable=false, options={"default"="'En attente'"})
     * @Assert\NotNull(message = "Ce champ ne peut pas etre vide! Veuillez le remplir.")
     *  @Assert\NotBlank(message = "Il parait que vous-avez oubliée de remplir le champ du nom !")
     * @Groups("demande")
     */
    private $etataccept ='En attente' ;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     * @Groups("demande")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="paquet", type="string", length=255, nullable=false)
     * @Groups("demande")
     */
    private $paquet ;
    public function __construct()
    {
        $this->idsp=new ArrayCollection();
    }

    public function getIddemande(): ?int
    {
        return $this->iddemande;
    }

    public function getIdev(): ?Evenement
    {
        return $this->idev;
    }

    public function setIdev(Evenement $idev): self
    {
        $this->idev = $idev;

        return $this;
    }

    public function getIdsp(): ?Sponsor
    {
        return $this->idsp;
    }

    public function setIdsp(Sponsor $idsp): self
    {
        $this->idsp = $idsp;

        return $this;
    }

    public function getEtataccept(): ?string
    {
        return $this->etataccept;
    }

    public function setEtataccept(string $etataccept): self
    {
        $this->etataccept = $etataccept;

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

    public function getPaquet(): ?string
    {
        return $this->paquet;
    }

    public function setPaquet(string $paquet): self
    {
        $this->paquet = $paquet;

        return $this;
    }
///// les fonctions eli taamlhom jdod fel repository public function 
    public function getDemandeByIdEvent($id){
        $list = array();

        if (is_object($this->idev))
{
        foreach( $this->idev as $event){
            if($event->getIdev() === $id)
            $list[]=array($event);
        }}
        
        return $list;
    }
    public function getDemandeByIdSpns($id){
        $list = array();

        if (is_object($this->idev))
{
        foreach( $this->idsp as $spons){
            if($spons->getIdsp() === $id)
            $list[]=array($spons);
        }}
        
        return $list;
    }
    


}

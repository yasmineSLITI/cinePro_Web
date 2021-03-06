<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SignalRepository;

/**
 * Signale
 *
 * @ORM\Table(name="signale", indexes={@ORM\Index(name="FK517", columns={"idClient"}), @ORM\Index(name="FK520", columns={"idPub"})})
 * @ORM\Entity(repositoryClass = SignalRepository::class)

 */
class Signale
{
    /**
     * @var int
     *
     * @ORM\Column(name="idSignal", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idsignal;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreSignal", type="integer", nullable=false)
     */
    private $nbresignal = '1';

    /**
     * @var \Client
     *
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idClient", referencedColumnName="idClient")
     * })
     */
    private $idclient;

    /**
     * @var \Publication
     *
     * @ORM\ManyToOne(targetEntity="Publication")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPub", referencedColumnName="idPub")
     * })
     */
    private $idpub;

    public function getIdsignal(): ?int
    {
        return $this->idsignal;
    }

    public function getNbresignal(): ?int
    {
        return $this->nbresignal;
    }

    public function setNbresignal(int $nbresignal): self
    {
        $this->nbresignal = $nbresignal;

        return $this;
    }

    public function getIdclient()
    {
        return $this->idclient;
    }

    public function setIdclient(?Client $idclient): self
    {
        $this->idclient = $idclient;

        return $this;
    }

    public function getIdpub()
    {
        return $this->idpub;
    }

    public function setIdpub(?Publication $idpub): self
    {
        $this->idpub = $idpub;

        return $this;
    }
}

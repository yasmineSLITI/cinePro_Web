<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Signale
 *
 * @ORM\Table(name="signale", indexes={@ORM\Index(name="FK520", columns={"idPub"}), @ORM\Index(name="FK517", columns={"idClient"})})
 * @ORM\Entity
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
     * @ORM\Column(name="idClient", type="integer", nullable=false)
     */
    private $idclient;

    /**
     * @var int
     *
     * @ORM\Column(name="idPub", type="integer", nullable=false)
     */
    private $idpub;

    /**
     * @var int
     *
     * @ORM\Column(name="nbreSignal", type="integer", nullable=false)
     */
    private $nbresignal = '0';

    public function getIdsignal(): ?int
    {
        return $this->idsignal;
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

    public function getIdpub(): ?int
    {
        return $this->idpub;
    }

    public function setIdpub(int $idpub): self
    {
        $this->idpub = $idpub;

        return $this;
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


}

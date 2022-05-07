<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 */
class Adresse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Email est obligatoire")
     * @Assert\Email(message = "L email '{{ value }}' n'est pas valide ")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Votre Governorat est obligatoire")
     * @Assert\Length(min=5 , minMessage=" Trés court ")
     */
    private $Governorat;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank(message="Votre Ville est obligatoire")4
     * @Assert\Length(min=5 , minMessage=" Trés court ")
     */
    private $Ville;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min=4 , minMessage=" le code postal doit etre composé de 4 entiers ")
     */
    private $codepostal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getGovernorat(): ?string
    {
        return $this->Governorat;
    }

    public function setGovernorat(string $Governorat): self
    {
        $this->Governorat = $Governorat;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getCodepostal(): ?int
    {
        return $this->codepostal;
    }

    public function setCodepostal(int $codepostal): self
    {
        $this->codepostal = $codepostal;

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Repository\CompteRepository;

/**
 * Compte
 *
 * @ORM\Table(name="compte")
* @ORM\Entity(repositoryClass = CompteRepository::class)
 * @UniqueEntity(
 * fields={"mail"},
 * message="L'email que vous avez tapé est déjà utilisé!")
 */
class Compte implements UserInterface
{   

    /**
     * @var int
     *
     * @ORM\Column(name="idCompte", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    private $idcompte;
    
    /**
     * @var string
     * @ORM\Column(name="userName", type="string", length=255, nullable=false)
     */
    
     private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=10, nullable=false)
     * @Assert\NotBlank()
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=20, nullable=false)
     * @Assert\NotBlank()
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255, nullable=false)
     * @Assert\NotBlank(), (message = "Ce champ ne doit pas être vide")
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit contenir au moins 8 caractéres")
     * @Assert\EqualTo(propertyPath="confirm_password", message = "Votre mot de passe doit être le même que celui de confirmation")
     */
    private $password;
    /**
     * @Assert\EqualTo(propertyPath="password", message = "Votre mot de passe doit être le même que vous l'avez tapé")
     */
    public $confirm_password;
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];
    

    /**
     * @var string
     *
     * @ORM\Column(name="Image", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $image;

    
    public function getIdcompte(): ?int
    {
        return $this->idcompte;
    }
    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }


    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
    public function getSalt()
    {
        
    }
    
    public function eraseCredentials()
    {
        
    }

    public function __toString()
    {
        return (string)$this->getIdcompte();
    }
   
   
}

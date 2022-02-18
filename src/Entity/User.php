<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity(fields={"email"}, message="Il existe déjà un compte avec cet e-mail")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email( message ="Email' {{ value }} ' n'est pas valide .", checkMX=true)
     */
    private $email;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

     /**
     * @ORM\Column(type="json")
     */
    private $roles = [];
  /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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


    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $photo;
    /**
     * @Vich\UploadableField(mapping="profils", fileNameProperty="photo")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $poid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $taille;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $attestation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $temoignage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $niveau;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $experiance;

    /**
     * @ORM\OneToMany(targetEntity=Regime::class, mappedBy="user")
     */
    private $regimes;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="user")
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=Programme::class, mappedBy="user")
     */
    private $programmes;

    /**
     * @ORM\OneToMany(targetEntity=SuiviRegime::class, mappedBy="user")
     */
    private $suiviRegime;

    /**
     * @ORM\OneToMany(targetEntity=SuiviProgramme::class, mappedBy="user")
     */
    private $suiviProgramme;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="user")
     */
    private $commandes;
   /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var Datetime
     */
    private $updateAt;
    public function __construct()
    {
        $this->regimes = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->programmes = new ArrayCollection();
        $this->suiviRegime = new ArrayCollection();
        $this->suiviProgramme = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->updateAt = new \Datetime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return (string) $this->password;
    }
      /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPoid(): ?string
    {
        return $this->poid;
    }

    public function setPoid(?string $poid): self
    {
        $this->poid = $poid;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(?string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getAtestation(): ?string
    {
        return $this->attestation;
    }

    public function setAtestation(?string $attestation): self
    {
        $this->attestation = $attestation;

        return $this;
    }

    public function getTemoignage(): ?string
    {
        return $this->temoignage;
    }

    public function setTemoignage(?string $temoignage): self
    {
        $this->temoignage = $temoignage;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getExperiance(): ?string
    {
        return $this->experiance;
    }

    public function setExperiance(?string $experiance): self
    {
        $this->experiance = $experiance;

        return $this;
    }

    /**
     * @return Collection|Regime[]
     */
    public function getRegimes(): Collection
    {
        return $this->regimes;
    }

    public function addRegime(Regime $regime): self
    {
        if (!$this->regimes->contains($regime)) {
            $this->regimes[] = $regime;
            $regime->setUser($this);
        }

        return $this;
    }

    public function removeRegime(Regime $regime): self
    {
        if ($this->regimes->removeElement($regime)) {
            // set the owning side to null (unless already changed)
            if ($regime->getUser() === $this) {
                $regime->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUser() === $this) {
                $commentaire->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Programme[]
     */
    public function getProgrammes(): Collection
    {
        return $this->programmes;
    }

    public function addProgramme(Programme $programme): self
    {
        if (!$this->programmes->contains($programme)) {
            $this->programmes[] = $programme;
            $programme->setUser($this);
        }

        return $this;
    }

    public function removeProgramme(Programme $programme): self
    {
        if ($this->programmes->removeElement($programme)) {
            // set the owning side to null (unless already changed)
            if ($programme->getUser() === $this) {
                $programme->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SuiviRegime[]
     */
    public function getSuiviRegime(): Collection
    {
        return $this->suiviRegime;
    }

    public function addSuiviRegime(SuiviRegime $suiviRegime): self
    {
        if (!$this->suiviRegime->contains($suiviRegime)) {
            $this->suiviRegime[] = $suiviRegime;
            $suiviRegime->setUser($this);
        }

        return $this;
    }

    public function removeSuiviRegime(SuiviRegime $suiviRegime): self
    {
        if ($this->suiviRegime->removeElement($suiviRegime)) {
            // set the owning side to null (unless already changed)
            if ($suiviRegime->getUser() === $this) {
                $suiviRegime->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SuiviProgramme[]
     */
    public function getSuiviProgramme(): Collection
    {
        return $this->suiviProgramme;
    }

    public function addSuiviProgramme(SuiviProgramme $suiviProgramme): self
    {
        if (!$this->suiviProgramme->contains($suiviProgramme)) {
            $this->suiviProgramme[] = $suiviProgramme;
            $suiviProgramme->setUser($this);
        }

        return $this;
    }

    public function removeSuiviProgramme(SuiviProgramme $suiviProgramme): self
    {
        if ($this->suiviProgramme->removeElement($suiviProgramme)) {
            // set the owning side to null (unless already changed)
            if ($suiviProgramme->getUser() === $this) {
                $suiviProgramme->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAtt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAtt): self
    {
        $this->updateAtt = $updateAtt;

        return $this;
    }
    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
    }
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \Datetime('now');
        }
        
    }
    public function getImageFile()
    {
        return $this->imageFile;
    }
}

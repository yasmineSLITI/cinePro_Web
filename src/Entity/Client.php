<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\ClientRepository;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @var int
     *
     * @ORM\Column(name="idClient", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("clients")
     */
    private $idclient;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     * @Groups("clients")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=false)
     * @Groups("clients")
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=250, nullable=false)
     * @Groups("clients")
     */
    private $email;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DateNaiss", type="date", nullable=true, options={"default"="NULL"})
     * @Groups("clients")
     */
    private $datenaiss = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255, nullable=false)
     * @Groups("clients")
     */
    private $role;

    /**
     * @var \Compte
     *
     * @ORM\ManyToOne(targetEntity="Compte")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userName", referencedColumnName="userName")
     * })
     * @Groups("clients")
     */
    private $username;

    /**
     * @ORM\OneToMany(targetEntity=Followingproduit::class, mappedBy="client")
     * @Groups("clients")
     */
    private $followings;

    public function __construct()
    {
        $this->followings = new ArrayCollection();
    }


    public function getIdclient(): ?int
    {
        return $this->idclient;
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

    public function getDatenaiss(): ?\DateTimeInterface
    {
        return $this->datenaiss;
    }

    public function setDatenaiss(?\DateTimeInterface $datenaiss): self
    {
        $this->datenaiss = $datenaiss;

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

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(?Compte $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection<int, Followingproduit>
     */
    public function getFollowings(): Collection
    {
        return $this->followings;
    }

    public function addFollowing(Followingproduit $following): self
    {
        if (!$this->followings->contains($following)) {
            $this->followings[] = $following;
            $following->setClient($this);
        }

        return $this;
    }

    public function removeFollowing(Followingproduit $following): self
    {
        if ($this->followings->removeElement($following)) {
            // set the owning side to null (unless already changed)
            if ($following->getClient() === $this) {
                $following->setClient(null);
            }
        }

        return $this;
    }

    public function listFollowing()
    {
        return $this->followings;
    }
}

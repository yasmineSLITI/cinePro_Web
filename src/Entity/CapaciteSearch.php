<?php

namespace App\Entity;

class CapaciteSearch
{

   private $capacite;

   
   public function getCapacite(): ?string
   {
       return $this->capacite;
   }

   public function setCapacite(string $nom): self
   {
       $this->capacite = $nom;

       return $this;
   }
}
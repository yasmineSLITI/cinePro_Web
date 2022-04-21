<?php

namespace App\Command;

use DateTime;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemiseProduit extends Command
{

    protected static $defaultName = 'app:remise-produit';

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Remise du prix de vente des produits dans la période du féstival');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $ProduitRepo = $this->entityManager->getRepository(Produit::class);
        $listProduit = $ProduitRepo->findAll();

        foreach ($listProduit as $produit) {
            $produit->setPrixventeunit($produit->getPrixventeunit() / 2);
            $this->entityManager->persist($produit);
            $this->entityManager->flush();
        }
    }
}

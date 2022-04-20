<?php

namespace App\Command;

use DateTime;
use App\Entity\Billet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateBilletStatus extends Command
{

    protected static $defaultName = 'app:archiver-billet';

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Update Archive attribute in Billet');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $BilletRepo = $this->entityManager->getRepository(Billet::class);
        $listBillet = $BilletRepo->findAll();

        foreach ($listBillet as $billet) {
           
            //CreatedOn Datetime
            $createdOn = $billet->getCreatedOn();
            $day_CreatedOn = (int)$createdOn->format("d");
            
            //Current Date
            $now = new DateTime();
            $nowFormat = $now->format('Y-m-d H:i:s');
            $currentDate = $now->getTimestamp();
            $currentDateday = date('d', $currentDate);
            
            if($currentDateday-$day_CreatedOn>7){

                $billet->setArchived(true);
                $this->entityManager->persist($billet);
                $this->entityManager->flush();

            }
            
        }
    }
}

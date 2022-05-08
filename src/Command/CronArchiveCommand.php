<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Publication;
use DateTime;



class CronArchiveCommand extends Command
{
    protected static $defaultName = 'cron:archive';


   
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }


    protected function configure(): void
    {
        $this->setDescription('archiver les publications');

        
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pub = $this->entityManager->getRepository(Publication::class);
        $publications = $pub->findAll();


        foreach ($publications as $publication) {
           
            //CreatedOn Datetime
            $datecreationpub = $publication->getDatecreationpub();
            $day_datecreationpub = (int)$datecreationpub->format("d");
            
            //Current Date
            $now = new DateTime();
            $nowFormat = $now->format('Y-m-d H:i:s');
            $currentDate = $now->getTimestamp();
            $currentDateday = date('d', $currentDate);
            
            if($currentDateday-$day_datecreationpub>1){

                $publication->setArchive(true);

                $this->entityManager->persist($publication);
                $this->entityManager->flush();

            }
            
        }
    }
}

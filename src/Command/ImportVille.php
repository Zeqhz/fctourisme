<?php

namespace App\Command;

use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use League\Csv\Reader;
use League\Csv\Statement;



#[AsCommand(
    name: 'app:import-villes-franche-comte',
    description: 'Import villes de Franche-Comté',
    hidden: false,
)]
class ImportVille extends Command
{
    private EntityManagerInterface $manager;

    /**
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stream = fopen('import/villes.csv', 'r');
        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        $stmt = Statement::create();

        //records = enregistrements
        $villes = $stmt->process($csv);
        foreach ($villes as $record) {

            if ($record["Département"]==25 || $record["Département"]==39 || $record["Département"]==70 || $record["Département"]==90){
                $ville = new Ville();
                if(empty($record["Ancienne commune"])){
                    $ville->setNom($record["Commune"]);
                }else {
                    $ville->setNom($record["Commune"]." ".$record["Ancienne commune"]);
                }
                $ville->setCodePostal($record["Code postal"]);
                $ville->setNomDepartement($record["Nom département"]);
                $ville->setNumeroDepartement($record["Département"]);
                $ville->setNomRegion($record["Région"]);
                $this->manager->persist($ville);


            }

        }
        $this->manager->flush();


        return Command::SUCCESS;

    }
}

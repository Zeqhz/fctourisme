<?php

namespace App\DataFixtures;

use App\Entity\Etablissement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class EtablissementFixtures extends Fixture
{
    private SluggerInterface $slugger;

    // Demander à symfony d'injecter le slugger au niveau du constructeur
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        // Initialisation de Faker
        $faker = Factory::create("fr_FR");
        for ($i=0;$i<50;$i++) {
            $etablissement = new Etablissement();
            $etablissement->setNom($faker->words($faker->numberBetween(3,10),true));
            $etablissement->setAdresseMail($faker->words($faker->numberBetween(3,10),true));
            $etablissement->setDescription($faker->paragraph(2, true));
            $etablissement->setNumeroTel($faker->words($faker->numberBetween(3,10),true));
            $etablissement->setAdressePostale($faker->words($faker->numberBetween(3,10),true));
            $etablissement->setImage($faker->words($faker->numberBetween(3,10),true));
            $etablissement->setSlug($this->slugger->slug($etablissement->getNom())->lower());

            $this->addReference("etablissement".$i,$etablissement);


            $manager->persist($etablissement);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            Fixture::class
        ];
    }
}

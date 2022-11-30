<?php

namespace App\DataFixtures;

use App\Entity\Etablissement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Repository\VilleRepository;

use Symfony\Component\String\Slugger\SluggerInterface;

class EtablissementFixtures extends Fixture
{
    private SluggerInterface $slugger;
    private VilleRepository $villeRepository;

    public function __construct(SluggerInterface $slugger, VilleRepository $villeRepository)
    {
        $this->slugger = $slugger;
        $this->villeRepository = $villeRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        $totalVille = $this->villeRepository->findAll();
        $minVille = min($totalVille);
        $maxVille = max($totalVille);

        for($i=0;$i<=50;$i++){
            $numVille = $faker->numberBetween($minVille->getId(),$maxVille->getId());
            $etablissement = new Etablissement();
            $etablissement->setNom($faker->word());
            $etablissement->setSlug($this->slugger->slug($etablissement->getNom())->lower());
            $etablissement->setDescription($faker->sentence(255,true));
            $etablissement->setNumeroTel(($faker->phoneNumber()));
            $etablissement->setAdresseMail($faker->email());
            $etablissement->setActif($faker->numberBetween(0,1));
            $etablissement->setAccueil($faker->numberBetween(0,1));
            $etablissement->setVille($this->villeRepository->find($numVille));
            $etablissement->setAdressePostale($faker->address());
            $etablissement->setCreatedAt($faker->dateTimeBetween('-10 years'));

            $manager->persist($etablissement);
        }
        $manager->flush();
    }


}

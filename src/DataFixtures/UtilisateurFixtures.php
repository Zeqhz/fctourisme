<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use function Symfony\Component\String\u;

class UtilisateurFixtures extends Fixture
{
    private  UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

        for($i=0;$i<=50;$i++) {
            $utilisateur = new Utilisateur();

            $utilisateur->setNom($faker->lastName());
            $utilisateur->setPrenom($faker->firstName());
            $utilisateur->setPseudo($faker->word());
            $utilisateur->setEmail($faker->email());
            $hash = $this->passwordHasher->hashPassword(
                $utilisateur,
                'password'
            );
            $utilisateur->setPassword($hash);
            $utilisateur->setActif($faker->numberBetween(0,1));
            $utilisateur->setCreatedAt($faker->dateTimeBetween('-5 years'));
            $utilisateur->setRoles(["ROLE_USER"]);
            $manager->persist($utilisateur);
        }
        $manager->flush();
    }
}

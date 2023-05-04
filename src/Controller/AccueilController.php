<?php

namespace App\Controller;

use App\Repository\EtablissementRepository;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    private EtablissementRepository $etablissementRepository;
    private VilleRepository $villeRepository;

    /**
     * @param EtablissementRepository $etablissementRepository
     * @param VilleRepository $villeRepository
     */
    public function __construct(EtablissementRepository $etablissementRepository, VilleRepository $villeRepository)
    {
        $this->etablissementRepository = $etablissementRepository;
        $this->villeRepository = $villeRepository;
    }


    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
        $ville90 = $this->villeRepository->findBy(['numeroDepartement' => 90]);
        $etablissements90 = $this->etablissementRepository->findBy(['ville' => $ville90]);
        $ville25 = $this->villeRepository->findBy(['numeroDepartement' => 25]);
        $etablissements25 = $this->etablissementRepository->findBy(['ville' => $ville25]);
        $ville70 = $this->villeRepository->findBy(['numeroDepartement' => 70]);
        $etablissements70 = $this->etablissementRepository->findBy(['ville' => $ville70]);
        $ville39 = $this->villeRepository->findBy(['numeroDepartement' => 39]);
        $etablissements39 = $this->etablissementRepository->findBy(['ville' => $ville39]);

        shuffle($etablissements25);
        shuffle($etablissements39);
        shuffle($etablissements90);
        shuffle($etablissements70);
        return $this->render('accueil/accueil.html.twig', [
            'etablissements25'=>$etablissements25,
            'etablissements39'=>$etablissements39,
            'etablissements90'=>$etablissements90,
            'etablissements70'=>$etablissements70
        ]);
    }
}
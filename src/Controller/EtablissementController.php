<?php

namespace App\Controller;

use App\Repository\EtablissementRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementController extends AbstractController
{
    private EtablissementRepository $etablissementRepository;
    public function __construct(EtablissementRepository $etablissementRepository,){
        $this->etablissementRepository = $etablissementRepository;
    }

    #[Route('/etablissement', name: 'app_etablissement')]
    public function getArticles(PaginatorInterface $paginator, Request $request): Response
    {
        $etablissements = $paginator->paginate(
            $this->etablissementRepository->findBy(['nom' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('partials/etablissement.html.twig',[
            "etablissement" => $etablissements
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Etablissement;
use App\Repository\EtablissementRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class EtablissementController extends AbstractController
{
    private EtablissementRepository $etablissementRepository;
    public function __construct(EtablissementRepository $etablissementRepository,){
        $this->etablissementRepository = $etablissementRepository;
    }

    #[Route('/etablissements', name: 'app_etablissements')]
    public function getEtablissement(PaginatorInterface $paginator, Request $request): Response
    {
        $etablissements = $paginator->paginate(
            $this->etablissementRepository->findBy(['actif' => 'true'],['nom' => 'ASC']),
            $request->query->getInt('page', 1), /*page number*/
            9 /*limit per page*/
        );

        return $this->render('etablissement/etablissement.html.twig',[
            "etablissements" => $etablissements
        ]);
    }

    #[Route('etablissement/{slug}', name:'app_etablissement_slug')]
    public function getEtablissementBySlug($slug): Response
    {
        $etablissement = $this->etablissementRepository->findOneBy(["slug" => $slug]);
        return $this->render('etablissement/detailEtablissement.html.twig', [
            "etablissement" => $etablissement
        ]);
    }

    #[Route('etablissement/{slug}/favoris', name:'app_etablissement_favoris')]
    public function addFavoris(UtilisateurRepository $repository , $slug) : Response
    {
        $etablissement = $this->etablissementRepository->findOneBy(["slug" => $slug]);
        $utilisateur = $repository->find($this->getUser());
        dd($utilisateur);

        if (in_array($etablissement, $utilisateur->getfavoris()->toArray())) {
            $etablissement->removeFavoris($utilisateur);
        } else {
            $etablissement->addFavoris($utilisateur);
        }
        return $this->redirectToRoute("app_etablissements");
    }
}

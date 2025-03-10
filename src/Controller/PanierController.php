<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\PanierService;


final class PanierController extends AbstractController
{
    #[Route('/{_locale}/panier', name: 'app_panier')]
    public function index(PanierService $panierService): Response
    {
        $total = $panierService->getTotal();
        return $this->render('panier/index.html.twig', [
            'controller_name' => 'PanierController',
            'panier' => $panierService->getContenu(),
            'total' => $total,
        ]);
    }

    #[Route('/{_locale}/panier/ajouter/{idProduit}/{quantite}', name: 'app_panier_ajouter')]
    public function ajouter(PanierService $panier, int $idProduit, int $quantite): Response {
        $panier->ajouterProduit($idProduit, $quantite);
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/{_locale}/panier/enlever/{idProduit}/{quantite}', name: 'app_panier_enlever')]
    public function enlever(PanierService $panier, int $idProduit, int $quantite): Response {
        $panier->enleverProduit($idProduit, $quantite);
        return $this->redirectToRoute('app_panier');
    }

    #[Route('{_locale}/panier/supprimer/{idProduit}', name: 'app_panier_supprimer')]
    public function supprimer(PanierService $panier, int $idProduit): Response {
        $panier->supprimerProduit($idProduit);
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/_locale/panier/vider', name: 'app_panier_vider')]
    public function vider(PanierService $panier): Response {
        $panier->vider();
        return $this->redirectToRoute('app_panier');
    }

    public function nombreProduits(PanierService $panier): Response
        {
            $nombre = $panier->getNombreProduits();
            return new Response((string)$nombre);
        }
}

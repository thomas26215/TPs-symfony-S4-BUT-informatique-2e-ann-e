<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use App\Entity\Categorie;

class BoutiqueController extends AbstractController
{
    #[Route('/boutique/{_locale}', name: 'app_boutique', requirements: ['_locale' => '%app.supported_locales%'], defaults: ['_locale' => 'fr'])]
    public function index(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findAll();
        return $this->render('boutique/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/rayon/{idCategorie}/{_locale}', name: 'app_boutique_rayon', requirements: ['_locale' => '%app.supported_locales%'], defaults: ['_locale' => 'fr'])]
    public function rayon(int $idCategorie, CategorieRepository $categorieRepository, ProduitRepository $produitRepository): Response
    {
        $categorie = $categorieRepository->find($idCategorie);
        if (!$categorie) {
            throw $this->createNotFoundException('La catégorie demandée n\'existe pas');
        }
        $produits = $produitRepository->findBy(['categorie' => $categorie]);

        return $this->render('boutique/rayon.html.twig', [
            'categorie' => $categorie,
            'produits' => $produits,
        ]);
    }

    public function topVentes(ProduitRepository $produitRepository): Response
    {
        // Supposons que vous ayez une méthode pour obtenir les meilleures ventes
        // Si ce n'est pas le cas, vous devrez l'implémenter dans ProduitRepository
        $produits = $produitRepository->findTopVentes();
        return $this->render('boutique/topVentes.html.twig', [
            'produits' => $produits,
        ]);
    }
}


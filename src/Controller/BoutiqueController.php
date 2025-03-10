<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Categorie;
use App\Entity\Produit;

class BoutiqueController extends AbstractController
{
    #[Route('/boutique/{_locale}', name: 'app_boutique', requirements: ['_locale' => '%app.supported_locales%'], defaults: ['_locale' => 'fr'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(Categorie::class)->findAll();
        return $this->render('boutique/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/rayon/{idCategorie}/{_locale}', name: 'app_boutique_rayon', requirements: ['_locale' => '%app.supported_locales%'], defaults: ['_locale' => 'fr'])]
    public function rayon(int $idCategorie, EntityManagerInterface $entityManager): Response
    {
        $categorie = $entityManager->getRepository(Categorie::class)->find($idCategorie);
        if (!$categorie) {
            throw $this->createNotFoundException('La catégorie demandée n\'existe pas');
        }
        $produits = $entityManager->getRepository(Produit::class)->findBy(['categorie' => $categorie]);

        return $this->render('boutique/rayon.html.twig', [
            'categorie' => $categorie,
            'produits' => $produits,
        ]);
    }

    public function topVentes(EntityManagerInterface $entityManager): Response
    {
        $produits = $entityManager->getRepository(Produit::class)->findTopVentes(5); // Récupère les 5 meilleures ventes
        return $this->render('boutique/topVentes.html.twig', [
            'produits' => $produits,
        ]);
    }
}

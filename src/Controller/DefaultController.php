<?php

namespace App\Controller;

use App\Service\ChangeMonnaieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route(
        path: '/{page}/{_locale}',
            name: 'app_default_index',
            requirements: ['_locale' => '%app.supported_locales%'],
            defaults: ['page' => 'index', '_locale' => 'fr'],
    )]
    public function index($page): Response
    {
        if ($page == 'index') {
            return $this->render('default/index.html.twig');
        } else {
            return $this->contact();
        }
    }

    #[Route(
        path: '/contact/{_locale}',
            name: 'app_default_contact',
            requirements: ['_locale' => '%app.supported_locales%'],
            defaults: ['_locale' => 'fr'],
    )]
    public function contact(): Response
    {
        return $this->render('default/contact.html.twig');
    }
}


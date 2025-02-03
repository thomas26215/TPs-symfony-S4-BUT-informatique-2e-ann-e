<?php

namespace App\Controller;

use App\Service\ChangeMonnaieService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route(
        path: '/{page}',
        name: 'app_default_index',
        defaults: ['page' => 'index'],
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
        path: '/contact',
        name: 'app_default_contact',
    )]
    public function contact(): Response
    {
        return $this->render('default/contact.html.twig');
    }
}


<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/demo')]
class DemoController extends AbstractController
{
    #[Route('/', name: 'demo_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('demo/index/index.html.twig');
    }

    #[Route('/admin', name: 'demo_admin', methods: ['GET'])]
    public function admin(): Response
    {
        return $this->render('demo/admin/index.html.twig');
    }
}

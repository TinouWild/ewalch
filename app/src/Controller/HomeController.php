<?php

namespace App\Controller;

use App\Service\SitemapGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home_index')]
    public function index(Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Votre email'
                ]
            ])
            ->add('object', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Objet'
                ]
            ])
            ->add('message', TextareaType::class, [
                'required' => true,
                'label' => false
            ])
            ->getForm()
        ;

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('app_home_index');
        }

        return $this->render('home/index.html.twig', [
            'form' => $form
        ]);
    }

    #[\Symfony\Component\Routing\Attribute\Route('/sitemap.xml', name: 'app_sitemap', methods: ['GET'])]
    public function sitemap(SitemapGenerator $sitemapGenerator): Response
    {
        return $sitemapGenerator->generateSitemap();
    }

    #[Route('/robots.txt', name: 'app_robots', methods: ['GET'])]
    public function robotDirectives(SitemapGenerator $sitemapGenerator): Response
    {
        return $sitemapGenerator->generateRobotsTxt();
    }
}

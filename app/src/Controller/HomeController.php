<?php

namespace App\Controller;

use App\Service\BrevoMailer;
use App\Service\SitemapGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class HomeController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/', name: 'app_home_index')]
    public function index(Request $request, BrevoMailer $brevoMailer): Response
    {
        $contactForm = $this->createFormBuilder()
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

        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $brevoMailer->sendMail($contactForm);
            $this->addFlash('success', "Votre message a été envoyé avec succès !");
            return $this->redirectToRoute('app_home_index');
        }

        $demoForm = $this->createFormBuilder()
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Votre email'
                ]
            ])
            ->getForm();
        $demoForm->handleRequest($request);
        if ($demoForm->isSubmitted() && $demoForm->isValid()) {
//            $brevoMailer->sendMail($contactForm);
//            $this->addFlash('success', "Votre message a été envoyé avec succès !");
            return $this->redirectToRoute('app_home_index');
        }

        return $this->render('home/index/index.html.twig', [
            'contactForm' => $contactForm,
            'demoForm' => $demoForm->createView(),
        ]);
    }

    #[Route('/sitemap.xml', name: 'app_sitemap', methods: ['GET'])]
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

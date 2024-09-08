<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapGenerator
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function generateSitemap(): Response
    {
        $response = new StreamedResponse(function () {
            echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
            echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

            $urls = [
                [
                    'loc' => $this->urlGenerator->generate('app_home_index', [], UrlGeneratorInterface::ABSOLUTE_URL),
                    'lastmod' => (new \DateTime())->format('Y-m-d'),
                    'changefreq' => 'weekly',
                    'priority' => '1.0',
                ],
            ];

            foreach ($urls as $url) {
                echo '  <url>' . PHP_EOL;
                echo '    <loc>' . htmlspecialchars($url['loc']) . '</loc>' . PHP_EOL;
                echo '    <lastmod>' . $url['lastmod'] . '</lastmod>' . PHP_EOL;
                echo '    <changefreq>' . $url['changefreq'] . '</changefreq>' . PHP_EOL;
                echo '    <priority>' . $url['priority'] . '</priority>' . PHP_EOL;
                echo '  </url>' . PHP_EOL;
            }

            echo '</urlset>' . PHP_EOL;
        });

        $response->headers->set('Content-Type', 'application/xml');

        return $response;
    }

    public function generateRobotsTxt(): Response
    {
        $response = new StreamedResponse(function () {
            $sitemapUrl = $this->urlGenerator->generate('app_sitemap', [], UrlGeneratorInterface::ABSOLUTE_URL);
            echo "# Fichier robots.txt pour etiennewalch.fr" . PHP_EOL;
            echo PHP_EOL;
            echo "User-agent: *" . PHP_EOL;
            echo "Disallow: /admin/" . PHP_EOL;
            echo "Disallow: /login/" . PHP_EOL;
            echo "Disallow: /beta/" . PHP_EOL;
            echo PHP_EOL;
            echo "Sitemap: " . htmlspecialchars($sitemapUrl) . PHP_EOL;
        });

        $response->headers->set('Content-Type', 'text/plain');

        return $response;
    }
}

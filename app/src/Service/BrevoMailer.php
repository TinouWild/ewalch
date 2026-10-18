<?php

namespace App\Service;

use Symfony\Component\Form\FormInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BrevoMailer
{
    private HttpClientInterface $httpClient;
    private string $brevoApiKey;

    public function __construct(HttpClientInterface $httpClient, string $brevoApiKey)
    {
        $this->httpClient = $httpClient;
        $this->brevoApiKey = $brevoApiKey;
    }

    private function send(string $object, string $content): void
    {
        $this->httpClient->request(
            'POST',
            'https://api.brevo.com/v3/smtp/email',
            [
                'headers' => [
                    'content-type' => 'application/json',
                    'accept' => 'application/json',
                    'api-key' => $this->brevoApiKey
                ],
                'json' => [
                    "sender" => [
                        "email" => "tinouclt@gmail.com"
                    ],
                    "to" => [
                        [
                            "name" => "WALCH Etienne",
                            "email" =>"tinouclt@gmail.com"
                        ]
                    ],
                    "subject" => $object,
                    "htmlContent" => $content
                ]
            ]
        );
    }

    /**
     * Échappe une saisie utilisateur avant de l'insérer dans le HTML de l'email.
     */
    private function escape(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * @param FormInterface $form
     * @return void
     */
    public function sendContactFormMail(FormInterface $form): void
    {
        $data = $form->getData();
        $need = $data['need'] ?? null;
        $content = "<html><head></head><body>";
        $content .= "<h1>Message de : " . $this->escape($data['email']) . "</h1>";
        $content .= "<p><strong>Besoin :</strong> " . ($need ? $this->escape($need) : 'Non précisé') . "</p>";
        $content .= "<p><strong>Message :</strong><br>" . nl2br($this->escape($data['message'])) . "</p>";
        $content .= "</body></html>";
        $subject = ($need ? '[' . $need . '] ' : '') . $data['object'];
        $this->send($subject, $content);
    }

    public function sendDemoFormMail(FormInterface $form): void
    {
        $data = $form->getData();
        $content = "<html><head></head><body>";
        $content .= "<h1>" . $this->escape($data['email']) . " souhaite faire une demo sur etiennewalch.fr</h1>";
        $content .= "</body></html>";
        $this->send('Demande de demo', $content);
    }
}

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
     * @param FormInterface $form
     * @return void
     */
    public function sendContactFormMail(FormInterface $form): void
    {
        $data = $form->getViewData();
        $content = "<html><head></head><body>";
        $content .= "<h1>Message de : " . $data['email'] . "</h1>";
        $content .= "<p>Message : " . $data['message'] . "</p>";
        $content .= "</body></html>";
        $this->send($data['object'], $content);
    }

    public function sendDemoFormMail(FormInterface $form): void
    {
        $data = $form->getViewData();
        $content = "<html><head></head><body>";
        $content .= "<h1>" . $data['email'] . " souhaite faire une demo sur etiennewalch.fr</h1>";
        $content .= "</body></html>";
        $this->send('Demande de demo', $content);
    }
}

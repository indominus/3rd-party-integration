<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;

class HomepageController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @param HttpClientInterface $httpClient
     * @return Response
     */
    public function index(Request $request, HttpClientInterface $httpClient): Response
    {

        $url = "https://dev.local/devs/3rd-party-cookies/public";
        try {
            $response = $httpClient->request(Request::METHOD_POST, $url, [
                'verify_peer' => false,  // see https://php.net/context.ssl for the following options
                'verify_host' => false,
            ])->toArray();
        } catch (ClientExceptionInterface | DecodingExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            return $this->render('homepage/index.html.twig', [
                'errors' => $e
            ]);
        }

        return $this->render('homepage/index.html.twig', [
            'response' => $response
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CookieCheckController extends AbstractController
{

    const COOKIE_NAME = '_3rd_cookie_';

    /**
     * @Route("/cookie")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('cookie_check/index.html.twig');
    }

    /**
     * @Route("/cookie/set", name="cookie_set")
     * @param Request $request
     * @return Response
     */
    public function set(Request $request): Response
    {
        setcookie(self::COOKIE_NAME, 1, time() + 3600, '/', '', $request->isSecure(), true);
        return new RedirectResponse($this->generateUrl('cookie_check'));
    }

    /**
     * @Route("/cookie/check", name="cookie_check")
     * @param Request $request
     * @return Response
     */
    public function check(Request $request): Response
    {

        $response = new Response();

        if (!isset($_COOKIE[self::COOKIE_NAME])) {
            return $response->setContent('0');
        }

        return $response->setContent('1');
    }
}

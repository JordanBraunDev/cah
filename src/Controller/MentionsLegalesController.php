<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MentionsLegalesController extends AbstractController
{
    /**
     * @Route("/mentions-legales", name="mentions_legales")
     */
    public function mentionsLegales(): Response
    {
        return $this->render('mentions_legales/mentions-legales.html.twig');
    }

    /**
     * @Route("/cgu", name="cgu")
     */
    public function cgu(): Response
    {
        return $this->render('mentions_legales/cgu.html.twig');
    }
}

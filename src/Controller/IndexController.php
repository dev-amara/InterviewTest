<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route(
     *     "/{vue_routing}",
     *      requirements={"vue_routing"="^(?!api|_(profiler|wdt)).*"}
     * )
     */
    public function index()
    {
        return $this->render('index.html.twig', []);
    }
}

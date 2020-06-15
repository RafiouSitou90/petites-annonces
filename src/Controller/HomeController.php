<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 *
 * @Route("/", name="app_home_")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("", name="index")
     *
     * @return Response
     */
    public function index()
    {
        return $this->render('home/index.html.twig', []);
    }
}

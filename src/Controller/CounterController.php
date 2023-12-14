<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CounterController extends AbstractController
{
    /**
     * @Route("/counter", name="app_counter")
     */
    public function index(): Response
    {
        return $this->render('counter/counter.html.twig', [
            'controller_name' => 'CounterController',
        ]);
    }
}

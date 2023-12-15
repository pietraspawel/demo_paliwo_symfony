<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    /**
     * @Route("/car", name="app_car")
     */
    public function index(): Response
    {
        return $this->render('car/car.html.twig', [
            'controller_name' => 'CarController',
        ]);
    }
}

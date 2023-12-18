<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CounterController extends AbstractController
{
    /**
     * @Route("/counter", name="app_counter")
     */
    public function index(CarRepository $carRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        if (count($carRepository->findByOwner($user)) == 0) {
            $car = null;
        } else {
            $car = true;
            // $car = $user->getActiveCar();
            // if ($car === null) {
            //     $car = $user->getCars()[0];
            // }
        }

        return $this->render('counter/counter.html.twig', [
            'car' => $car,
        ]);
    }
}

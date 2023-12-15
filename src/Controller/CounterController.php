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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();
        if (count($user->getCars()) == 0) {
            $car = null;
        } else {
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

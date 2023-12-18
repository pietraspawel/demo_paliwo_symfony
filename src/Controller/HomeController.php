<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        if ($user !== null) {
            return $this->redirectToRoute('app_odometer_index');
        }
        return $this->redirectToRoute('app_login');
    }
}

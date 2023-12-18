<?php

namespace App\Controller;

use App\Entity\Odometer;
use App\Form\OdometerType;
use App\Repository\OdometerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/odometer")
 */
class OdometerController extends AbstractController
{
    /**
     * @Route("/", name="app_odometer_index", methods={"GET"})
     */
    public function index(OdometerRepository $odometerRepository): Response
    {
        return $this->render('odometer/index.html.twig', [
            'odometers' => $odometerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_odometer_new", methods={"GET", "POST"})
     */
    public function new(Request $request, OdometerRepository $odometerRepository): Response
    {
        $odometer = new Odometer();
        $form = $this->createForm(OdometerType::class, $odometer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $odometerRepository->add($odometer, true);

            return $this->redirectToRoute('app_odometer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('odometer/new.html.twig', [
            'odometer' => $odometer,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_odometer_show", methods={"GET"})
     */
    public function show(Odometer $odometer): Response
    {
        return $this->render('odometer/show.html.twig', [
            'odometer' => $odometer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_odometer_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Odometer $odometer, OdometerRepository $odometerRepository): Response
    {
        $form = $this->createForm(OdometerType::class, $odometer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $odometerRepository->add($odometer, true);

            return $this->redirectToRoute('app_odometer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('odometer/edit.html.twig', [
            'odometer' => $odometer,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_odometer_delete", methods={"POST"})
     */
    public function delete(Request $request, Odometer $odometer, OdometerRepository $odometerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$odometer->getId(), $request->request->get('_token'))) {
            $odometerRepository->remove($odometer, true);
        }

        return $this->redirectToRoute('app_odometer_index', [], Response::HTTP_SEE_OTHER);
    }
}

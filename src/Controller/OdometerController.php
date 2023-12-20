<?php

namespace App\Controller;

use App\Entity\Odometer;
use App\Form\OdometerType;
use App\Repository\CarRepository;
use App\Repository\OdometerRepository;
use App\Service\OdometerService;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/", name="app_odometer_index", methods={"GET", "POST"})
     */
    public function index(
        Request $request,
        CarRepository $carRepository,
        OdometerRepository $odometerRepository,
        OdometerService $odometerService,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();
        $car = $user->getCurrentCar();
        $odometer = new Odometer();
        $odometer->setCar($car);
        $lastRefuel = $odometerRepository->findTheNewestByCar($car);
        $lastRefuelDate = '2000-01-01';
        if ($lastRefuel !== null) {
            $lastRefuelDate = $lastRefuel->getDate()->format('Y-m-d');
        }
        if ($car === null || !$car->isActive()) {
            $car = $carRepository->findOneByOwner($user);
            $user->setCurrentCar($car);
            $entityManager->flush();
        }
        $odometerCollection = [];
        if ($car !== null) {
            $odometerCollection = $odometerRepository->findBy(['car' => $car->getId()], ['date' => 'DESC']);
            $odometerService->preprocessCollection($odometerCollection);
        }

        $form = $this->createForm(OdometerType::class, $odometer, ['last_refuel_date' => $lastRefuelDate]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $odometerRepository->add($odometer, true);
            $this->addFlash('notice', 'Zapisałeś stan licznika!');
            return $this->redirectToRoute('app_odometer_index');
        }

        return $this->render('odometer/odometer.html.twig', [
            'user_car' => $car,
            'cars' => $carRepository->findByOwner($user),
            'odometers' => $odometerCollection,
            'form' => $form->createView(),
            'average_consumption' => $odometerService->calculateAverageConsumption($odometerCollection),
        ]);
    }

    /**
     * @Route("/change-car", methods={"GET"})
     */
    public function changeCarWrongMethod()
    {
        return $this->redirectToRoute('app_odometer_index');
    }

    /**
     * @Route("/change-car", name="app_odometer_change_car", methods={"POST"})
     */
    public function changeCar(
        Request $request,
        CarRepository $carRepository,
        EntityManagerInterface $entityManager
    ): Response {
        if ($this->isCsrfTokenValid('select-current', $request->request->get('_token'))) {
            $id = filter_input(INPUT_POST, 'car-select');
            $user = $this->getUser();
            $car = $carRepository->find($id);
            $user->setCurrentCar($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_odometer_index');
    }

    /**
     * @Route("/edit/{id}", name="app_odometer_edit", methods={"GET", "POST"})
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
        if ($this->isCsrfTokenValid('delete' . $odometer->getId(), $request->request->get('_token'))) {
            $odometerRepository->remove($odometer, true);
        }

        return $this->redirectToRoute('app_odometer_index', [], Response::HTTP_SEE_OTHER);
    }
}

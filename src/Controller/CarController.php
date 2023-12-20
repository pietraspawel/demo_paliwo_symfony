<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/car")
 */
class CarController extends AbstractController
{
    /**
     * @Route("/", name="app_car_index", methods={"GET", "POST"})
     */
    public function index(
        CarRepository $carRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();
        $car = new Car();

        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $car->setOwner($user);
            $carRepository->add($car, true);
            $this->addFlash('notice', 'Dodałeś samochód!');
            return $this->redirectToRoute('app_car_index');
        }

        return $this->render('car/car.html.twig', [
            'cars' => $carRepository->findByOwner($user),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit", name="app_car_edit", methods={"POST"})
     */
    public function edit(
        Request $request,
        CarRepository $carRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $data = json_decode($request->getContent(), true);
        if (!$this->isCsrfTokenValid('edit' . $data['id'], $data['_token'])) {
            return new JsonResponse(['error' => 'Unknown'], JsonResponse::HTTP_NOT_FOUND);
        }

        $car = $carRepository->findOneBy(['id' => $data['id']]);
        if (!$car) {
            return new JsonResponse(['error' => 'Car not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        $car->setDescription($data['description']);
        $entityManager->flush();
        return new JsonResponse(['success' => true]);
    }

    /**
     * @Route("/edit", methods={"GET"})
     */
    public function editWrongMethod()
    {
        return $this->redirectToRoute('app_car_index');
    }

    /**
     * @Route("/{id}", name="app_car_delete", methods={"POST"})
     */
    public function delete(Request $request, Car $car, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $car->getId(), $request->request->get('_token'))) {
            $car->setActive(false);
            $entityManager->flush();
            $this->addFlash('warning', 'Usunąłeś samochód!');
        }

        return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function deleteWrongMethod(): Response
    {
        return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
    }
}

<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile")
     */
    public function index(
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $form = $this->createForm(ChangePasswordFormType::class, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $user->setPassword(
            //     $userPasswordHasher->hashPassword(
            //         $user,
            //         $form->get('plainPassword')->getData()
            //     )
            // );

            // $entityManager->persist($user);
            // $entityManager->flush();

            // $this->addFlash(
            //     'notice',
            //     'Zarejestrowałeś użytkownika!'
            // );
        }

        return $this->render('profile/index.html.twig', [
            'changePasswordForm' => $form->createView(),
        ]);
    }
}

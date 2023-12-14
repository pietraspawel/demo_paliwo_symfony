<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPasswordFormType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        // Deny access to authenticaded users.
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $user = new User();

        $registrationForm = $this->createForm(RegistrationFormType::class, $user);
        $registrationForm->handleRequest($request);

        if ($registrationForm->isSubmitted() && $registrationForm->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $registrationForm->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'Zarejestrowałeś użytkownika!'
            );
            return $this->redirectToRoute('app_login');
        }

        return $this->render('authentication/register.html.twig', [
            'registrationForm' => $registrationForm->createView(),
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Deny access to authenticaded users.
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('authentication/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout(Security $security): Response
    {
        $this->addFlash(
            'notice',
            'Wylogowałeś się'
        );

        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route("/forgot-password", name="app_forgot_password")
     */
    public function forgotPassword(
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        MailerInterface $mailer
    ): Response {
        // Deny access to authenticaded users.
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(ForgotPasswordFormType::class, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRepository->findOneBy(['email' => $form->get('email')->getData()]);
            if ($user !== null) {
                $diff = false;
                do {
                    $user->generateResetCode();
                    $userWithCode = $userRepository->findOneBy(['resetCode' => $user->getResetCode()]);
                    if ($userWithCode === null) {
                        $diff = true;
                    }
                } while (!$diff);

                $entityManager->flush();

                // send email
                $email = (new Email())
                    ->from('test@pietraspawel.pl')
                    ->to('pawel.z.pietras@gmail.com')
                    ->subject('Time for Symfony Mailer!')
                    ->text('Sending emails is fun again!')
                    ->html('<p>See Twig integration for better HTML integration!</p>');

                $mailer->send($email);
            }

            $this->addFlash(
                'notice',
                'Na Twój adres email wysłano link do zresetowania hasła!'
            );
            return $this->redirectToRoute('app_login');
        }

        return $this->render('authentication/forgot_password.html.twig', [
            'forgotPasswordForm' => $form->createView(),
        ]);
    }
}

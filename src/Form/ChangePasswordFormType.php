<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'attr' => ['autofocus' => '', 'placeholder' => 'Wpisz hasło'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Wpisz stare hasło',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Hasło musi mieć przynajmniej {{ limit }} znaków',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'label' => 'Stare hasło'
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Hasła muszą się zgadzać.',
                'options' => ['attr' => ['class' => 'password-field', 'autocomplete' => 'new-password']],
                'required' => true,
                'first_options'  => [
                    'label' => 'Nowe hasło',
                    'attr' => ['placeholder' => 'Wpisz nowe hasło'],
                ],
                'second_options' => [
                    'label' => 'Powtórz nowe hasło',
                    'attr' => ['placeholder' => 'Powtórz nowe hasło'],
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Wpisz hasło',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Hasło musi mieć przynajmniej {{ limit }} znaków',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Zmień hasło'
            ])
        ;
        ;
    }
}

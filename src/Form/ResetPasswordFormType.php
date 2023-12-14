<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Hasła muszą się zgadzać.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => [
                    'label' => 'Hasło',
                    'attr' => ['placeholder' => 'Wpisz hasło', 'autofocus' => ''],
                ],
                'second_options' => [
                    'label' => 'Powtórz hasło',
                    'attr' => ['placeholder' => 'Powtórz hasło'],
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
                'label' => 'Zarejestruj'
            ])
        ;
    }
}

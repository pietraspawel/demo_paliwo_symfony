<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ForgotPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'autocomplete' => 'email',
                    'placeholder' => 'Wpisz adres email',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Wpisz adres email',
                    ]),
                    new Email([
                        'message' => 'Wpisz prawidłowy adres email',
                    ]),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Adres email za długi',
                    ]),
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Resetuj'
            ])
        ;
    }
}

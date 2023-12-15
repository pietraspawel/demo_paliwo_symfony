<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', TextType::class, [
                'attr' => ['autofocus' => '', 'placeholder' => 'Opisz samochód'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Wpisz opis samochodu',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Opis musi mieć przynajmniej {{ limit }} znaków',
                        'max' => 255,
                        'maxMessage' => 'Opis jest za długi',
                    ]),
                ],
                'label' => 'Opis',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}

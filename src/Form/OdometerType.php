<?php

namespace App\Form;

use App\Entity\Odometer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class OdometerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', IntegerType::class, [
                'attr' => ['autofocus' => '', 'placeholder' => 'Wpisz stan licznika'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Wpisz stan licznika',
                    ]),
                    new Range([
                        'min' => 0,
                        'max' => 9999999,
                        'notInRangeMessage' => 'Wartość musi być pomiędzy {{ min }} a {{ max }}',
                    ]),
                ],
                'label' => 'Stan',
            ])
            ->add('fuel', NumberType::class, [
                'attr' => ['placeholder' => 'Wpisz ilość wlanego paliwa'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Wpisz ilość paliwa',
                    ]),
                    new Range([
                        'min' => 0,
                        'max' => 999.99,
                        'notInRangeMessage' => 'Wartość musi być pomiędzy {{ min }} a {{ max }}',
                    ]),
                ],
                'invalid_message' => 'Nieprawidłowa wartość',
                'label' => 'Paliwo',
            ])
            ->add('price', MoneyType::class, [
                'attr' => ['placeholder' => 'Wpisz cenę'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Wpisz cenę',
                    ]),
                    new Range([
                        'min' => 0,
                        'max' => 999999999.99,
                        'notInRangeMessage' => 'Wartość musi być pomiędzy {{ min }} a {{ max }}',
                    ]),
                ],
                'currency' => false,
                'invalid_message' => 'Nieprawidłowa wartość',
                'label' => 'Cena/litr',
            ])
            ->add('date', DateType::class, [
                'attr' => ['placeholder' => 'Wpisz datę tankowania'],
                'constraints' => [
                    new NotBlank(['message' => 'Wpisz datę']),
                    new Range([
                        'min' => $options['last_refuel_date'],
                        'max' => 'today',
                        'notInRangeMessage' => 'Data nie może być starsza niż data ostatniego tankowania i nie młodsza niż dzisiaj',
                    ]),
                ],
                'data' => new \DateTime(),
                'invalid_message' => 'Nieprawidłowa wartość',
                'label' => 'Data',
                'format' => 'ddMMyyyy',
                'widget' => 'choice',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Odometer::class,
            'last_refuel_date' => '2000-01-01',
        ]);
    }
}

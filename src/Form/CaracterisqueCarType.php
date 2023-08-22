<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints As Assert;

class CaracterisqueCarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('carburant',ChoiceType::class,[
                'expanded'=> false,
                'multiple'=>false,
                'choices'=>[
                    'essence'=>'essence',
                    'diésel'=>'diesel',
                    'éléctrique'=>'electrique',
                ],
                    'constraints'=>[
                        new Assert\NotBlank(),
                        new Assert\Choice(['essence','diesel','electrique']),
                    ]
            ])
            ->add('nombrePorte',ChoiceType::class,[
                'expanded'=> false,
                'multiple'=>false,
                'choices'=>[
                    '5 portes'=>5,
                    '2 portes'=>2,
                    '3 portes'=>3,
                    ],
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Choice([5,2,3])
                ]

                ])
            ->add('boiteVitesse',ChoiceType::class,[
                'expanded'=> false,
                'multiple'=>false,
                'choices'=>[
                    'manuel'=>'manuel',
                    'semi-auto'=>'semi-auto',
                    'automatique'=>'automatique'
                    ],
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Choice(['manuel','semi-auto','automatique'])
                ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'csrf_protection' => false,
        ]);
    }
}

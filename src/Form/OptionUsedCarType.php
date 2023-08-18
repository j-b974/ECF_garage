<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints As Assert;

class OptionUsedCarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gps',CheckboxType::class,[
                'required'=>false,
                'constraints'=>[

                ]
            ])
            ->add('radarRecule',CheckboxType::class,[
                'required'=>false
            ])
            ->add('climatisation',CheckboxType::class,[
                'required'=>false
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

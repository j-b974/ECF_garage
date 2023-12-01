<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints As Assert;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'required'=>false,
                'attr' => [
                    'class'=>'form-control'
                ],
                'label'=> 'Auteur de l\' Avis ',
                'required'=>false,
                'label_attr'=>[
                ],
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Length(['min'=>3 , 'max'=>600])


                ]
            ])
            ->add('commentaire',TextareaType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'style'=>'height: 180px'
                ],
                'label'=>'Votre commentaire',
                'constraints'=>[
                    new Assert\NotBlank(),
                   // new Assert\LessThan(600), pour un number
                    new Assert\Length(['min'=>9 , 'max'=>600])
                ]
            ])
            ->add('note',ChoiceType::class,[
                'expanded'=>true,// important pour definir si radio , liste ou check
                'multiple'=>false,// important pour definir si radio , liste ou check
                'choices'=>[
                    '1'=>1,
                    '2'=>2,
                    '3'=>3,
                    '4'=> 4,
                    '5'=>5
                ],
                'attr'=>[
                    'class'=>'d-flex mb-4'
                ],
                'required' => true,
                'label_attr'=>[
                    'class'=>'form-check-label me-4'
                ],
                'label'=>'Attribuez une Note :',
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Length(['min'=>1 , 'max'=> 5])

                ]

            ])
            ->add('adress_email',EmailType::class,[
                'attr' => [
                    'class'=>'form-control'
                ],
                'required'=>false,
                'label'=> 'Adresse email',
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Email()
                ]
            ])

            ->add('submit',SubmitType::class,[
                'attr'=>[
                    'class'=>' d-flex btn btn-info mt-4 ms-auto'

                ],
                'label'=>'Créé un Avis'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

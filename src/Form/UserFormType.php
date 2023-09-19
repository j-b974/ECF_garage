<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints As Assert;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Length(['min'=>3 , 'max'=>25])
                ]
            ])
            ->add('prenom',TextType::class,[
                'required'=>false,
            ])
            ->add('adress_email',EmailType::class,[
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Length(['min'=>10 , 'max'=>100]),
                    new Assert\Email()
                ]
            ])

            ->add('role',ChoiceType::class,[
                'expanded'=>true,// important pour definir si radio , liste ou check
                'multiple'=>false,// important pour definir si radio , liste ou check
                'choices'=>[
                    'Employer'=>'Employ',
                    'Administrateur'=>'Administrateur',
                ],
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Choice(['Employ','Administrateur'])
                ]
            ])
            ->add('password',TextType::class,[
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Length(['min'=>8 , 'max'=>250])
                ],
                'required'=>false,
            ])
            ->add('submit',SubmitType::class,[
                'attr'=>[
                    'class'=>' d-flex btn btn-info mt-4 ms-auto'
                ],
                'label'=>'Envoyer'
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

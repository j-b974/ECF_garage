<?php

namespace App\Form;

use App\Entity\OptionUsedCar;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

use Symfony\Component\Validator\Constraints As Assert;
class UsedCarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix', MoneyType::class,[
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Positive(),
                    new Assert\LessThan(999999)
                ]
            ])
            ->add('annee_fabrication',DateType::class,[
                'widget' => 'choice',
                'format'=>"dd / MM / yyyy"
            ])
            ->add('kilometrage',IntegerType::class,[
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Positive(),
                    new Assert\LessThan(999999)
                ]
            ])

            ->add('image',FileType::class,[

                'label' => 'Voiture occassion ( file gif / png / jpeg)',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/gif',
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'charger un valide image de voiture',
                    ])
                ],
            ])

            ->add('submit',SubmitType::class,[
                'attr'=>[
                    'class'=>' d-flex btn btn-info mt-4 ms-auto'
                ],
                'label'=>'Ajouter'
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

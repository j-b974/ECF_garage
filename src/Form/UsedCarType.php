<?php

namespace App\Form;

use App\Entity\OptionUsedCar;
use App\Entity\UsedCar;
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
                'format'=>"dd / MM / yyyy",
                'years'=>range(date('Y'),1975,)
            ])
            ->add('kilometrage',IntegerType::class,[
                'constraints'=>[
                    new Assert\NotBlank(),
                    new Assert\Positive(),
                    new Assert\LessThan(999999)
                ]
            ])

            ->add('lstImage',FileType::class,[

                'label' => 'Voiture occassion ( file gif / png / jpeg)',
                'multiple'=>true,

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new Assert\All(// multiple est true donc contrain pour chaque fichier
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/png',
                                'image/jpeg',
                                'image/webp'
                            ],
                            'mimeTypesMessage' => 'charger une image valide de voiture',
                        ])
                    ),

                ],
            ])

            ->add('submit',SubmitType::class,[
                'attr'=>[
                    'class'=>' d-flex btn btn-info mt-4 ms-auto'
                ],
                'label'=>$options['label_btn']
            ])

        ;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            "data_class"=>UsedCar::class,
            "label_btn"=>"Envoyer"
        ]);
    }

}

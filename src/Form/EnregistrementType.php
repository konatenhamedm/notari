<?php

namespace App\Form;

use App\Entity\Enregistrement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EnregistrementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero',TextType::class,[
                'label'=>false,
            ])
            ->add('numeroEnregistrement',TextType::class,[
                'label'=>false,
            ])
            ->add('dateEnvoi', DateType::Class, [
                 "label" => false,
                "required" => false,
                "widget" => 'single_text',
                "input_format" => 'Y-m-d',
                "by_reference" => true,
                "empty_data" => '',
            ])
            ->add('dateRetour', DateType::Class, [
                 "label" => false,
                "required" => false,
                "widget" => 'single_text',
                "input_format" => 'Y-m-d',
                "by_reference" => true,
                "empty_data" => '',
            ])
            ->add('path',FileType::class,[
                'label'=>false,
                'data_class' => null,
                'required'=> false,
                'mapped' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ],

            ])
           /* ->add('dossier')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Enregistrement::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Dossier;
use App\Entity\Type;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DossierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numeroOuverture')
            ->add('description')
            ->add('dateCreation', DateType::Class, [
                "label" => "Date création",
                "required" => false,
                "widget" => 'single_text',
                "input_format" => 'Y-m-d',
                "by_reference" => true,
                "empty_data" => '',
            ])
            ->add('documentSignes', CollectionType::class, [
                'entry_type' => DocumentSigneType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add' => true,
                'label' => false,
                'by_reference' => false,
                'allow_delete' => true,
                'prototype' => true,

            ])
            ->add('pieceVendeurs', CollectionType::class, [
                'entry_type' => PieceVendeurType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add' => true,
                'label' => false,
                'by_reference' => false,
                'allow_delete' => true,
                'prototype' => true,

            ])
            ->add('identifications', CollectionType::class, [
                'entry_type' => IdentificationType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add' => true,
                'label' => false,
                'by_reference' => false,
                'allow_delete' => true,
                'prototype' => true,

            ])
            ->add('redactions', CollectionType::class, [
                'entry_type' => RedactionType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add' => true,
                'label' => false,
                'by_reference' => false,
                'allow_delete' => true,
                'prototype' => true,

            ])
            ->add('obtentions', CollectionType::class, [
                'entry_type' => ObtentionType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add' => true,
                'label' => false,
                'by_reference' => false,
                'allow_delete' => true,
                'prototype' => true,

            ])
            ->add('remises', CollectionType::class, [
                'entry_type' => RemiseType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add' => true,
                'label' => false,
                'by_reference' => false,
                'allow_delete' => true,
                'prototype' => true,

            ])
            ->add('pieces', CollectionType::class, [
                'entry_type' => PieceType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add' => true,
                'label' => false,
                'by_reference' => false,
                'allow_delete' => true,
                'prototype' => true,

            ])
            ->add('enregistrements', CollectionType::class, [
                'entry_type' => EnregistrementType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add' => true,
                'label' => false,
                'by_reference' => false,
                'allow_delete' => true,
                'prototype' => true,

            ])
            ->add('numeroClassification')
           /* ->add('dateCreation')*/
            ->add('dateClassification', DateType::Class, [
               "label" => "Date de classification",
               "required" => false,
               "widget" => 'single_text',
               "input_format" => 'Y-m-d',
               "by_reference" => true,
               "empty_data" => '',
           ])
            ->add('objet')
           /* ->add('dossierWorkflow')*/
            /*->add('typeActe', EntityType::class, [
               'required' => false,
               'class' => Type::class,
               'query_builder' => function (EntityRepository $er) {
                   return $er->createQueryBuilder('u')
                       ->where('u.active = :val')
                       ->setParameter('val', 1)
                       ->orderBy('u.id', 'DESC');
               },
               'label' =>'Type acte',
               'placeholder' => 'Selectionner un recepteur',
               'choice_label' => function ($user) {
                   return $user->getTitre();
               },
               'attr'=>['class' =>'form-control select2','id'=>'validationCustom05']

           ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dossier::class,
        ]);
    }
}

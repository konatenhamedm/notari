<?php

namespace App\Form;

use App\Entity\GestionWorkflow;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GestionWorkflowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('workflow', CollectionType::class, [
                    'entry_type' => WorkflowType::class,
                    'entry_options' => [
                        'label' => false
                    ],
                    'allow_add' => true,
                    'label' => false,
                    'by_reference' => false,
                    'allow_delete' => true,
                    'prototype' => true,

                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GestionWorkflow::class,
        ]);
    }
}
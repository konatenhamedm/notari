<?php

namespace App\Form;

use App\Classe\Search;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{

    private $village;
    private $array = [];
    private $array2 = [];

    public function __construct()
    {
      //  $this->village = $repository->getListe();
        /*  foreach ($this->village as $p)
          {
              $this->array[] = $p['libelle'];
          }

          for ($i=0;$i<2;$i++)
          {
              $this->array2 = $this->array[$i];
          }*/
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

           /* ->add('village', EntityType::class, [
                // looks for choices from this entity
                'label'=>false,
                'class' => Departement::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'libDepartement',

                // used to render a select box, check boxes or radios
                'multiple' => true,
                 'expanded' => false,
                 'attr' => ['class' => 'custom-select select2 border-primary'],
            ])
          ->add('type',ChoiceType::class,
              [
                  'label'=>false,
                  'expanded'     => false,
                  'placeholder' => 'Choisissez un type',
                  'required'     => true,
                   'attr' => ['class' => 'custom-select select2 border-primary'],
                  'multiple' => false,
                  //'choices_as_values' => true,

                  'choices'  => array_flip([
                      'PDF'        => 'PDF',
                      'EXCEL'       => 'EXCEL',

                  ]),
              ])*/;
           /* ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'target' => '__blank'
                ]
            ]);*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'crsf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return ""; // TODO: Change the autogenerated stub
    }

}

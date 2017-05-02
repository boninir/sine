<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpertiseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('interventions', CollectionType::class, [
                'entry_type'   => InterventionType::class,
                /*'allow_add'    => true,
                'allow_delete' => true,*/
                'attr' => [
                    'data-add-label' => 'Ajouter une intervention',
                    'data-add-id' => 'add_intervention',
                    'data-label' => 'Intervention supplémentaire n°'
                ],
                'entry_options' => ['vehicle' => $options['vehicle']],
            ])

            /*->add('pictures', CollectionType::class, [
                'entry_type' => FileType::class,
                'label'      => false,
                'allow_add'    => true,
                'allow_delete' => true,
                'attr' => [
                    'data-add-label' => 'Ajouter une photo',
                    'data-add-id' => 'add_picture',
                    'data-label' => 'Photo supplémentaire n°'
                ],
                'entry_options' => ['label' => false],
                'required' => false,
            ])*/
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['vehicle' => null]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_expertise';
    }

}
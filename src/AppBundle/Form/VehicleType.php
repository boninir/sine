<?php

namespace AppBundle\Form;

use AppBundle\Entity\Vehicle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('registration', null, array('label' => 'Immatriculation'))
            ->add('mark', null, array('label' => 'Marque'))
            ->add('model', null, array('label' => 'Modèle'))
            ->add('type', ChoiceType::class, array(
                'label' => 'Type',
                'choices' => array(
                    'Auto-école' => 'Auto-école',
                    'Felix Faure' => 'Felix Faure',
                    'SVO' => 'SVO',
                    'VO' => 'VO',
                    'VO 0 KM' => 'VO 0 KM',
                    'Autre' => 'Autre',
                )
            ))
            ->add('cv', null, array('label' => 'CV'))
            ->add('frame', null, array('label' => 'N° châssis'))
            ->add('color', null, array('label' => 'Couleur'))
            ->add('releaseDate', null, array('label' => 'Mise en circulation'))
            ->add('kilometerTraveled', null, array('label' => 'Kilomètres parcouru'))
            ->add('kilometerOnCounter', null, array('label' => 'Kilomètres au compteur'))
            ->add('sapVoucher', null, array('label' => 'Bon SAP'))
            ->add('fuel',
                EntityType::class,
                array('class' => 'AppBundle:Fuel',
                'choice_label' => 'denomination',
                'label' => 'Motorisation',
                'expanded' => true,
                'multiple' => false))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Vehicle::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_vehicle';
    }
}

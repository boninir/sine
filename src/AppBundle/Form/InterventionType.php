<?php

namespace AppBundle\Form;

use AppBundle\Entity\Intervention;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterventionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('select', ChoiceType::class, [
                'choices' => [true],
                'label' => false,
                'choice_label' => false,
                'mapped' => false,
                'expanded' => true,
                'multiple' => true,
                'choice_attr' => function() {
                    return [
                        'data-toggle' => 'toggle',
                        'data-on' => 'Oui',
                        'data-off' => 'Non',
                        "data-onstyle" => "success",
                        "data-offstyle" => "danger",
                    ];
                }
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Intervention::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_intervention';
    }


}

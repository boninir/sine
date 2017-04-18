<?php

namespace AppBundle\Form;

use AppBundle\Entity\Intervention;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterventionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::POST_SET_DATA, function(FormEvent $event) use($options) {
                $intervention = $event->getData();
                $form = $event->getForm();
                if ($intervention === null) {
                    $form->add('comment', TextareaType::class, [
                        'label' => false,
                        'mapped' => false,
                        'required' => false,
                    ]);

                    return;
                }


                $value = null;
                foreach ($options['vehicle']->getInterventions() as $vehicleIntervention) {
                    if ($vehicleIntervention->getIntervention() === $intervention) {
                        $value = $vehicleIntervention;

                        break;
                    }
                }

                $form->add('comment', TextareaType::class, [
                    'label' => false,
                    'mapped' => false,
                    'required' => false,
                    'data' => $value === null ? null : $value->getComment()
                ]);

                if (empty($intervention->getAnswers())) {
                    $form->add('select', ChoiceType::class, [
                        'choices' => [true],
                        'label' => false,
                        'choice_label' => false,
                        'mapped' => false,
                        'expanded' => true,
                        'multiple' => true,
                        'choice_attr' => function() {
                            return [
                                'class' => 'choose-intervention',
                                'data-toggle' => 'toggle',
                                'data-on' => 'Oui',
                                'data-off' => 'Non',
                                "data-onstyle" => "success",
                                "data-offstyle" => "danger",
                            ];
                        },
                        'data' => $value === null ? [] : $value->getAnswers(),
                    ]);
                } else {
                    $form->add('select', ChoiceType::class, [
                        'choices' => $intervention->getAnswers(),
                        'label' => false,
                        'choice_label' => function($value) { return $value; },
                        'mapped' => false,
                        'expanded' => true,
                        'multiple' => true,
                        'data' => $value === null ? [] : $value->getAnswers(),
                    ]);
                }
            }
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
            'vehicle' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_intervention';
    }


}

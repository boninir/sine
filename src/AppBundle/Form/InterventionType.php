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
            ->add('comment', TextareaType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
            ])
            ->addEventListener(FormEvents::POST_SET_DATA, function(FormEvent $event) {
                if ($event->getData() === null) {
                    return;
                }

                $form = $event->getForm();

                if (empty($event->getData()->getAnswers())) {
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
                        }
                    ]);
                } else {
                    $form->add('select', ChoiceType::class, [
                        'choices' => $event->getData()->getAnswers(),
                        'label' => false,
                        'choice_label' => function($value) { return $value; },
                        'mapped' => false,
                        'expanded' => true,
                        'multiple' => true,
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

<?php

namespace AppBundle\Form;

use AppBundle\Entity\Intervention;
use AppBundle\Entity\TypeIntervention;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterventionType extends AbstractType
{
    private $doctrine;

    public function __construct(Registry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
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
                    $form
                        ->add('type', HiddenType::class, [
                            'label' => false,
                            'mapped' => false,
                            'attr' => ['class' => 'type']
                        ])
                        ->add('denomination', TextType::class, [
                            'label' => 'Dénomination',
                            'mapped' => false,
                            'required' => false,
                            'attr' => ['class' => 'form-control']
                        ])
                        ->add('comment', TextareaType::class, [
                            'label' => 'Commentaire',
                            'mapped' => false,
                            'required' => false,
                        ])
                        ->add('time', NumberType::class, [
                            'label' => 'Temps à passer (en minutes)',
                            'mapped' => false,
                            'required' => false,
                        ])
                        ->add('select', HiddenType::class, [
                            'mapped' => false,
                            'data' => true,
                        ])
                    ;

                    return;
                }

                $value = null;
                foreach ($options['vehicle']->getInterventions() as $vehicleIntervention) {
                    if ($vehicleIntervention->getIntervention() === $intervention) {
                        $value = $vehicleIntervention;

                        break;
                    }
                }

                $form
                    ->add('comment', TextareaType::class, [
                        'label' => false,
                        'mapped' => false,
                        'required' => false,
                        'data' => $value === null ? null : $value->getComment(),
                    ])
                    ->add('time', HiddenType::class, [
                        'label' => 'Temps à passer (en minutes)',
                        'mapped' => false,
                        'required' => false,
                        'data' => $value === null ? null : $value->getTime(),
                    ])
                ;

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
            })
            ->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) use($options) {
                $intervention = $event->getData();
                $form = $event->getForm();

                if (array_key_exists('type', $intervention)) {
                    if ($intervention['denomination'] === null || $intervention['denomination'] === '') {
                        $form->getParent()->remove($form->getName());

                        return;
                    }

                    $type = $this->doctrine
                        ->getRepository(TypeIntervention::class)
                        ->find($intervention['type'])
                    ;

                    if ($type === null) {
                        $form->addError(new FormError("Ce type d'intervention n'existe pas."));

                        return;
                    }

                    $form->setData((new Intervention())
                        ->setTypeIntervention($type)
                        ->setDenomination($intervention['denomination'])
                        ->setRequired(false)
                    );
                }
            })
        ;
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

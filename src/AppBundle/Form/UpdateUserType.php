<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UpdateUserType extends AbstractType
{
    /**
     * @var PasswordEncoder
     */
    private $encoder;

    public function __construct(UserPasswordEncoder $encoder)
    {
        $this->encoder = $encoder;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label' => 'Login', 'required' => false])
            ->add('oldPassword', PasswordType::class, ['label' => 'Ancien mot de passe', 'required' => false])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Nouveau Mot de passe'],
                'second_options' => ['label' => 'Confirmer le nouveau mot de passe'],
                'required' => false,
            ])
            ->add('mail', TextType::class, ['label' => 'Adresse email', 'required' => false])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Expert' => 'ROLE_EXPERT',
                    'Sous traitant' => 'ROLE_SUBCONTRACTOR',
                    'Mécanicien' => 'ROLE_MECHANICIAN',
                    'Carrossier' => 'ROLE_BODYBUILDER',
                    'Peintre' => 'ROLE_PAINTER',
                    'Nettoyeur' => 'ROLE_CLEANER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'expanded' => true,
                'label' => 'Rôle(s)',
                'multiple' => true,
                'required' => false,
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event) {
                $form = $event->getForm();
                $user = $event->getData();

                if (!$form->isValid()) {
                    return;
                }

                if ($form->get('oldPassword')->getData() !== null
                    && !$this->encoder->isPasswordValid($user, $form->get('oldPassword')->getData())
                ) {
                    $form->get('oldPassword')->addError(new FormError('Mauvais mot de passe, veuillez réessayer.'));
                }
            })
        ;
    }
}

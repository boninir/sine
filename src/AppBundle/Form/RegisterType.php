<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RegisterType extends AbstractType
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $checker;

    public function __construct(AuthorizationCheckerInterface $checker)
    {
        $this->checker = $checker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label' => 'Login'])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],
            ])
            ->add('mail', TextType::class, ['label' => 'Adresse email'])
        ;

        if ($this->checker->isGranted('ROLE_ADMIN')) {
            $builder->add('roles', ChoiceType::class, [
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
            ]);
        }

        $builder->add('submit', SubmitType::class, [
            'label' => 'Confirmer',
            'attr' => ['class' => 'btn btn-success btn-block']
        ]);
    }
}

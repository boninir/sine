<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\View\ChoiceListView;
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
            ->add('societyName', ChoiceType::class, [
            'choices' => [
                'Peugeot' => 'Peugeot',
                'Citroën' => 'Citroën',
                'Sineo' => 'Sineo',
                'Aramis' => 'Aramis',
                'Nissan' => 'Nissan',
                ],
                'expanded' => false,
                'label' => 'Nom de la société',
                'multiple' => false,
            ])
            ->add('societyCity', ChoiceType::class, [
            'choices' => [
                'Fâches' => 'Fâches',
                'Hellemes' => 'Hellemes',
                'Lille' => 'Lille',
                'Lomme' => 'Lomme',
                'Roncq' => 'Roncq',
                'Roubaix' => 'Roubaix',
                'Villeneuve D\'Ascq' => 'Villeneuve D\'Ascq'
                ],
                'expanded' => false,
                'label' => 'Ville de la société',
                'multiple' => false,
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Expert' => 'ROLE_EXPERT',
                    'Controleur d\'entrée' => 'ROLE_CONTROL',
                    'Maître d\'atelier' => 'ROLE_MASTER_WORKSHOP',
                    'Transporteur' => 'ROLE_TRANSPORTER',
                    'Mécanicien' => 'ROLE_MECHANICIAN',
                    'Carrossier' => 'ROLE_BODYBUILDER',
                    'Peintre' => 'ROLE_BEAUTICIAN',
                    'Nettoyeur' => 'ROLE_CLEANER',
                    'Photographe' => 'ROLE_PHOTOGRAPHER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'expanded' => false,
                'label' => 'Rôle',
                'multiple' => true,
            ]);
        //if ($this->checker->isGranted('ROLE_USER')) { DE-COMMENTER APRES
    }
}

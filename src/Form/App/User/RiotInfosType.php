<?php

namespace App\Form\App\User;

use App\Entity\Account\User\RiotInfo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RiotInfosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gamename', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm bg-dark border-primary mb-2',
                    'placeholder' => 'Votre Pseudo Riot (exemple : GlobNot)',
                ],
            ])
            ->add('tagline', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control form-control-sm bg-dark border-primary mb-2',
                    'placeholder' => 'Votre ID Riot (exemple : EUW1 ou 9999)',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter un compte Riot',
                'attr' => [
                    'class' => 'btn w-100 btn-primary',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RiotInfo::class,
        ]);
    }
}

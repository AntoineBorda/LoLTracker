<?php

namespace App\Form\App\User;

use App\Entity\Account\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordConfirmationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Confirm password',
                'attr' => [
                    'class' => 'form-control form-control-sm bg-dark border-primary mb-2',
                    'placeholder' => 'Confirm password',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'CONFIRMER la suppression du compte et de toutes les données associées.',
                'attr' => [
                    'class' => 'btn w-100 btn-danger mt-4',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

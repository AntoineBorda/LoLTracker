<?php

namespace App\Form\App\Tracker;

use App\Entity\App\Tracker\DataLeague;
use App\Entity\App\Tracker\League;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LeagueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dataLeague', EntityType::class, [
                'class' => DataLeague::class,
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => League::class,
        ]);
    }
}

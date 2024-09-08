<?php

namespace App\Controller\Admin\Tracker;

use App\Entity\App\Tracker\League;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class LeagueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return League::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('player', 'Joueur')
                ->setCrudController(PlayerCrudController::class)
                ->autocomplete(),
            AssociationField::new('dataLeague', 'Leagues')
                ->setCrudController(DataLeagueCrudController::class)
                ->autocomplete(),
        ];
    }
}

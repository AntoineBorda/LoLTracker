<?php

namespace App\Controller\Admin\Tracker;

use App\Entity\App\Tracker\Team;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class TeamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Team::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('player', 'Joueur')
                ->setCrudController(PlayerCrudController::class)
                ->autocomplete(),
            AssociationField::new('dataTeam', 'Teams')
                ->setCrudController(DataTeamCrudController::class)
                ->autocomplete(),
        ];
    }
}

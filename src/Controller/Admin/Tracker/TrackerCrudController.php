<?php

namespace App\Controller\Admin\Tracker;

use App\Entity\App\Tracker\Tracker;
use App\Service\Tracker\TrackerUpdateService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class TrackerCrudController extends AbstractCrudController
{
    public function __construct(
        private TrackerUpdateService $trackerUpdateService,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Tracker::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('player', 'Player')
                ->setCrudController(PlayerCrudController::class)
                ->autocomplete(),
            AssociationField::new('riotInfo', 'RiotId')
                ->setCrudController(RiotInfoCrudController::class)
                ->autocomplete(),
            BooleanField::new('visible', 'Visibility'),
        ];
    }

    public function persistEntity(
        EntityManagerInterface $entityManager,
        $entityInstance
    ): void {
        $entityInstance->setUser($this->getUser());
        $entityInstance->setVisible(true);
        parent::persistEntity($entityManager, $entityInstance);
        $this->trackerUpdateService->updateTracker([$entityInstance]);
    }
}

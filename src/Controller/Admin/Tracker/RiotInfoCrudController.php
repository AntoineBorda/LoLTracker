<?php

namespace App\Controller\Admin\Tracker;

use App\Entity\Account\User\RiotInfo;
use App\Entity\App\Tracker\Tracker;
use App\Service\Tracker\RiotInfoService;
use App\Service\Tracker\TrackerUpdateService;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RiotInfoCrudController extends AbstractCrudController
{
    public function __construct(
        private RiotInfoService $riotInfoService,
        private TrackerUpdateService $trackerUpdateService
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return RiotInfo::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            yield AssociationField::new('player', 'Player')
                ->setCrudController(PlayerCrudController::class)
                ->autocomplete(),
            yield TextField::new('gameName', 'Gamename'),
            yield TextField::new('tagLine', 'Tagline'),
        ];
    }

    public function persistEntity(
        EntityManagerInterface $entityManager,
        $entityInstance
    ): void {
        parent::persistEntity($entityManager, $entityInstance);
        $this->riotInfoService->updateRiotInfo($entityInstance);

        $tracker = new Tracker();
        $tracker->setRiotInfo($entityInstance);
        $tracker->setUser($this->getUser());
        $tracker->setPlayer($entityInstance->getPlayer());
        $tracker->setVisible(true);

        $entityManager->persist($tracker);
        $entityManager->flush();

        $this->trackerUpdateService->updateTracker([$tracker]);
    }
}

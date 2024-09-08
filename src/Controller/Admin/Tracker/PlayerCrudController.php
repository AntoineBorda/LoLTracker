<?php

namespace App\Controller\Admin\Tracker;

use App\Entity\App\Tracker\Player;
use App\Form\App\Tracker\LeagueType;
use App\Form\App\Tracker\TeamType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PlayerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Player::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ImageField::new('image', 'Picture')
                ->setBasePath('')
                ->setUploadDir('/public/uploads/img')
                ->setFormTypeOptions(['disabled' => true]),
            TextField::new('summonerName', 'Pseudo'),
            TextField::new('role', 'Role'),
            AssociationField::new('country', 'Country')
                ->setCrudController(DataCountryCrudController::class)
                ->autocomplete()
                ->formatValue(function ($entity) {
                    if (null !== $entity && method_exists($entity, 'getFlag')) {
                        $flag = $entity->getFlag();

                        return "<img src='$flag' style='height: 20px;' />";
                    } else {
                        return 'N/A';
                    }
                }),
            TextField::new('firstName', 'Firstname'),
            TextField::new('lastName', 'Lasname'),
            TextField::new('twitch', 'Twitch'),
            CollectionField::new('teams', 'Teams')
                ->allowAdd(true)
                ->allowDelete(true)
                ->setEntryType(TeamType::class)
                ->setFormTypeOptions(['by_reference' => false]),
            CollectionField::new('leagues', 'Leagues')
                ->allowAdd(true)
                ->allowDelete(true)
                ->setEntryType(LeagueType::class)
                ->setFormTypeOptions(['by_reference' => false]),
        ];
    }

    public function persistEntity(
        EntityManagerInterface $entityManager,
        $entityInstance
    ): void {
        $summonerName = $entityInstance->getSummonerName();
        $playerId = $summonerName;

        $entityInstance->setId($playerId);

        parent::persistEntity($entityManager, $entityInstance);
    }
}

<?php

namespace App\Controller\Admin\Tracker;

use App\Entity\App\Tracker\DataTeam;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DataTeamCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DataTeam::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Team'),
            TextField::new('code', 'Code'),
            ImageField::new('image', 'Logo')
                ->setBasePath('')
                ->setUploadDir('/public/uploads/img')
                ->setFormTypeOptions(['disabled' => true]),
            ImageField::new('alternativeImage', 'Alternative Logo')
                ->setBasePath('')
                ->setUploadDir('/public/uploads/img')
                ->setFormTypeOptions(['disabled' => true]),
            ImageField::new('backgroundImage', 'Background')
                ->setBasePath('')
                ->setUploadDir('/public/uploads/img')
                ->setFormTypeOptions(['disabled' => true]),
            TextField::new('status', 'Status'),
            TextField::new('homeLeagueName', 'Home League Name'),
            TextField::new('homeLeagueRegion', 'Home League Region'),
        ];
    }
}

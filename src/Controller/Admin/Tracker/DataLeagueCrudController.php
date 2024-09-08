<?php

namespace App\Controller\Admin\Tracker;

use App\Entity\App\Tracker\DataLeague;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DataLeagueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DataLeague::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'League'),
            TextField::new('region', 'Region'),
            ImageField::new('image', 'Logo')
                ->setBasePath('')
                ->setUploadDir('/public/uploads/img')
                ->setFormTypeOptions(['disabled' => true]),
            IntegerField::new('priority', 'Priority'),
            IntegerField::new('position', 'Position'),
            TextField::new('status', 'Status'),
        ];
    }
}

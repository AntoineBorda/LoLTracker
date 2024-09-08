<?php

namespace App\Controller\Admin\Tracker;

use App\Entity\App\Tracker\DataCountry;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DataCountryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DataCountry::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('common', 'Country'),
            TextField::new('official', 'Official'),
            TextField::new('cca2', 'CCA2'),
            TextField::new('region', 'Region'),
            ImageField::new('flag', 'Flag')
                ->setBasePath('')
                ->setUploadDir('/public/uploads/img')
                ->setFormTypeOptions(['disabled' => true]),
        ];
    }
}

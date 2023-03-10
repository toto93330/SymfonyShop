<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

  
    public function configureFields(string $pageName): iterable
    {
        return [
           TextField::new('name'),
           SlugField::new('slug')->setTargetFieldName('name'),
           ImageField::new('picture')
           ->setBasePath('/uploads/images/')
           ->setUploadDir('public/uploads/images/')
           ->setUploadedFileNamePattern('[randomhash].[extension]'),
           AssociationField::new('category'),
           TextareaField::new('description'),
           TextField::new('subtitle'),
           MoneyField::new('price')->setCurrency('EUR')

        ];
    }
    
}

<?php

namespace App\Controller\Admin;

use App\Entity\UserAddress;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserAddressCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserAddress::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}

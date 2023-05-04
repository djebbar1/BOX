<?php

namespace App\Controller\Admin;

use App\Entity\Borrow;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;



class BorrowCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Borrow::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateTimeField::new('dateBorrow'),
            DateTimeField::new('dateReturn'),
            AssociationField::new('idUser'),
            AssociationField::new('books')
        ];
    }
    
}

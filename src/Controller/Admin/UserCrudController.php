<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Endroid\QrCode\Builder\BuilderInterface;
use Symfony\Component\Uid\Uuid;
use Endroid\QrCodeBundle\Response\QrCodeResponse;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $user = new User();
        $user->setUuid(Uuid::v4());
        return $user;
    }
  /*  public function __construct(BuilderInterface $customQrCodeBuilder)
{
    $result = $customQrCodeBuilder
        ->size(400)
        ->margin(20)
        ->build();
        $response = new QrCodeResponse($result);
}*/
    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),
            TextField::new('name'),
            EmailField::new('email'),
            //IntegerField::new('uuid'),
            TextField::new('uuid')->hideOnForm(),
            //TextField::new('roles'),
            ImageField::new('avatar')->setBasePath('uploads/avatar/')->setUploadDir('public/uploads/avatar/')->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),
        ];
    }
    
}

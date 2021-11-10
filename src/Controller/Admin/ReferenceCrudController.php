<?php

namespace App\Controller\Admin;

use App\Entity\Reference;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReferenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reference::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
    return $crud
        // the labels used to refer to this entity in titles, buttons, etc.
        ->setEntityLabelInSingular('Référence')
        ->setEntityLabelInPlural('Références')
        ;
    }   

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('reference', 'Référrence')->setColumns(4),
            BooleanField::new('isPrimary', 'Référence principal')->setColumns(6)->setCssClass('float-end my-4'),
            TextField::new('subTitle', 'Titre secondaire')->setColumns(8),
            AssociationField::new('product', "Produit")->setColumns(5),
            TextEditorField::new('subDescription', 'Déscription secondaire')->hideOnIndex()->setColumns(12),
            MoneyField::new('price', 'Prix secondaire')->setCurrency('EUR')->setColumns(2),
            ImageField::new('image', 'Image anexe 1')
                ->setBasePath('uploads/images/reference')
                ->setUploadDir('public/uploads/images/reference')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false)
                ->setColumns(6)

        ];
    }
}

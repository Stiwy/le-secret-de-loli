<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DomCrawler\Field\FileFormField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
    return $crud
        // the labels used to refer to this entity in titles, buttons, etc.
        ->setEntityLabelInSingular('Produit')
        ->setEntityLabelInPlural('Produits')
        ;
    }   

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Id')->onlyOnIndex(),
            TextField::new('reference', 'Référrence'),
            TextField::new('title', 'Titre')->hideOnIndex(),
            TextEditorField::new('description', 'Déscription')->hideOnIndex(),
            IntegerField::new('price', 'Prix'),
            IntegerField::new('tva', 'T.V.A')->hideOnIndex(),
            ImageField::new('primaryImage', 'Image principal')
                ->hideOnIndex()
                ->setBasePath('uploads//images/primary')
                ->setUploadDir('public/uploads/images/primary')
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            ImageField::new('otherImage1', 'Image anexe 1')
                ->hideOnIndex()
                ->setBasePath('uploads/images/others')
                ->setUploadDir('public/uploads/images/others')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),

        ];
    }
}

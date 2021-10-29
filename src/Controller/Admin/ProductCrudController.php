<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
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
            ArrayField::new('reference', 'Référrence')->setColumns(4),
            TextField::new('title', 'Titre')->setColumns(8),
            BooleanField::new('toHide', 'Masquer le produits')->setColumns(6)->setCssClass('mt-4')->setHelp('Si cocher le produits sera masqué'),
            ArrayField::new('keywork', 'Mots clés')->setColumns(6),
            SlugField::new('slug', 'Liens de la page')->setTargetFieldName('title')->hideOnIndex()->setColumns(7),
            AssociationField::new('id_category', "Catégorie")->setColumns(5),
            TextEditorField::new('description', 'Déscription')->hideOnIndex()->setColumns(12),
            MoneyField::new('price', 'Prix')->setCurrency('EUR')->setColumns(2),
            ChoiceField::new('tva', 'T.V.A')->hideOnIndex()
                ->setColumns(2)
                ->setChoices([
                    '20%' => (float)'1,20',
                    '10%' => (float)'1,10',
                    '5,5%' => (float)'1,055',
                    '2,1%' => (float)'1,021'
            ]),
            ImageField::new('primaryImage', 'Image principal')
                ->setBasePath('uploads//images/primary')
                ->setUploadDir('public/uploads/images/primary')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setColumns(12),
            ImageField::new('image', 'Image anexe 1')
                ->hideOnIndex()
                ->setBasePath('uploads/images/others')
                ->setUploadDir('public/uploads/images/others')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false)
                ->setColumns(6),
            ImageField::new('image2', 'Image anexe 2')
                ->hideOnIndex()
                ->setBasePath('uploads/images/others')
                ->setUploadDir('public/uploads/images/others')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false)
                ->setColumns(6),
            ImageField::new('image3', 'Image anexe 3')
                ->hideOnIndex()
                ->setBasePath('uploads/images/others')
                ->setUploadDir('public/uploads/images/others')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false)
                ->setColumns(6),
            ImageField::new('image4', 'Image anexe 4')
                ->hideOnIndex()
                ->setBasePath('uploads/images/others')
                ->setUploadDir('public/uploads/images/others')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false)
                ->setColumns(6),

        ];
    }
}

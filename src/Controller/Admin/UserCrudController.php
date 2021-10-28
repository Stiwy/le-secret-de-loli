<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
    return $crud
        // the labels used to refer to this entity in titles, buttons, etc.
        ->setEntityLabelInSingular('Utilisateur')
        ->setEntityLabelInPlural('Utilisateurs')
        ;
    }   

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Id')->onlyOnIndex(),
            TextField::new('fullname', 'Nom complet')->onlyOnIndex(),
            TextField::new('firstname', 'Prénom')->hideOnIndex()->setColumns(6),
            TextField::new('lastname', 'Nom')->hideOnIndex()->setColumns(6),
            EmailField::new('email', 'E-mail')->setColumns(8),
            IntegerField::new('phone', 'Téléphone')->setColumns(4),
            TextField::new('password', 'Mot de passe')->hideOnIndex()->setColumns(6)->setHelp("Le mot de passe doit contenir au moins : 1 majuscule, 1 miniscule, 1 chiffre."),
            BooleanField::new('isAdmin', 'Roles')->setColumns(6)->setHelp("L'utilisateur est un administrateur ?")->setCssClass('p-4')->hideOnDetail(),
            TextField::new('address', 'Adresse')->hideOnIndex()->setColumns(12),
            IntegerField::new('zipCode', 'Code postal')->hideOnIndex()->setColumns(3),
            TextField::new('city', 'Ville')->hideOnIndex()->setColumns(9),
            DateTimeField::new('insertDate', 'Date d\'inscription')->hideOnForm()->hideOnIndex(),
        ];
    }
}

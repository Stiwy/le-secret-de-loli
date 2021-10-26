<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom', 
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 2, 25)
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom', 
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 2, 25)
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre e-mail', 
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 6, 60)
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Votre téléphone', 
                'constraints' => [
                    new NotBlank(),
                    new Length(10),
                    new Regex("/^[0-9]{10}$/")
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et sa confirmation doivent êtres identiques.',
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 8, 60),
                    new Regex("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/")
                ],
                'first_options' => [
                    'help' => 'Le mot de passe doit contenir au moins : 1 majuscule, 1 miniscule, 1 chiffre',
                    'label' => 'Votre mot de passe',
                ],
                'second_options' => [
                    'label' => 'Confirmer votre mot de passe', 
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse postal', 
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 5)
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville', 
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 2, 80)
                ]
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'Code postal', 
                'constraints' => [
                    new NotBlank(),
                    new Length(5),
                    new Regex("/^[0-9]{5}$/")
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire",
                'attr' => [
                    'class' => 'btn btn-outline-custom f-right'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class EditUserInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom', 
                'attr' => [
                    'onfocus' =>  'formLabel(document.getElementById("edit_user_information_firstname_group"), document.getElementById("edit_user_information_firstname_label"))',
                    'onfocusout' => 'formPlaceholder(document.getElementById("edit_user_information_firstname_group"), document.getElementById("edit_user_information_firstname_label"), document.getElementById("edit_user_information_firstname"))',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 2, 25)
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom', 
                'attr' => [
                    'onfocus' =>  'formLabel(document.getElementById("edit_user_information_lastname_group"), document.getElementById("edit_user_information_lastname_label"))',
                    'onfocusout' => 'formPlaceholder(document.getElementById("edit_user_information_lastname_group"), document.getElementById("edit_user_information_lastname_label"), document.getElementById("edit_user_information_lastname"))',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 2, 25)
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre e-mail', 
                'attr' => [
                    'onfocus' =>  'formLabel(document.getElementById("edit_user_information_email_group"), document.getElementById("edit_user_information_email_label"))',
                    'onfocusout' => 'formPlaceholder(document.getElementById("edit_user_information_email_group"), document.getElementById("edit_user_information_email_label"), document.getElementById("edit_user_information_email"))',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 6, 60)
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Votre téléphone', 
                'attr' => [
                    'onfocus' =>  'formLabel(document.getElementById("edit_user_information_phone_group"), document.getElementById("edit_user_information_phone_label"))',
                    'onfocusout' => 'formPlaceholder(document.getElementById("edit_user_information_phone_group"), document.getElementById("edit_user_information_phone_label"), document.getElementById("edit_user_information_phone"))',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 9, 10),
                    new Regex("/^[0-9]{9,10}$/")
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse postal', 
                'attr' => [
                    'onfocus' =>  'formLabel(document.getElementById("edit_user_information_address_group"), document.getElementById("edit_user_information_address_label"))',
                    'onfocusout' => 'formPlaceholder(document.getElementById("edit_user_information_address_group"), document.getElementById("edit_user_information_address_label"), document.getElementById("edit_user_information_address"))',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 5)
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville', 
                'attr' => [
                    'onfocus' =>  'formLabel(document.getElementById("edit_user_information_city_group"), document.getElementById("edit_user_information_city_label"))',
                    'onfocusout' => 'formPlaceholder(document.getElementById("edit_user_information_city_group"), document.getElementById("edit_user_information_city_label"), document.getElementById("edit_user_information_city"))',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 2, 80)
                ]
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'Code postal', 
                'attr' => [
                    'onfocus' =>  'formLabel(document.getElementById("edit_user_information_zipCode_group"), document.getElementById("edit_user_information_zipCode_label"))',
                    'onfocusout' => 'formPlaceholder(document.getElementById("edit_user_information_zipCode_group"), document.getElementById("edit_user_information_zipCode_label"), document.getElementById("edit_user_information_zipCode"))',
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 4, 5),
                    new Regex("/^[0-9]{4,5}$/")
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Enregistrer",
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

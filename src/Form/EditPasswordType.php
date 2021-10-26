<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class EditPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('old_password', PasswordType::class, [
                'label' => 'Votre mot de passe actuel',
                'mapped' => false,
                'attr' => [
                    'onfocus' =>  'formLabel(document.getElementById("edit_password_old_password_group"), document.getElementById("edit_password_old_password_label"))',
                    'onfocusout' => 'formPlaceholder(document.getElementById("edit_password_old_password_group"), document.getElementById("edit_password_old_password_label"), document.getElementById("edit_password_old_password"))',
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Le mot de passe et sa confirmation doivent êtres identiques.',
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 8, 60),
                    new Regex("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/")
                ],
                'first_options' => [
                    'label' => 'Votre nouveau mot de passe',
                    'attr' => [
                        'onfocus' =>  'formLabel(document.getElementById("edit_password_new_password_first_group"), document.getElementById("edit_password_new_password_first_label"))',
                        'onfocusout' => 'formPlaceholder(document.getElementById("edit_password_new_password_first_group"), document.getElementById("edit_password_new_password_first_label"), document.getElementById("edit_password_new_password_first"))',
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmer le nouveauvotre mot de passe', 
                    'attr' => [
                        'onfocus' =>  'formLabel(document.getElementById("edit_password_new_password_second_group"), document.getElementById("edit_password_new_password_second_label"))',
                        'onfocusout' => 'formPlaceholder(document.getElementById("edit_password_new_password_second_group"), document.getElementById("edit_password_new_password_second_label"), document.getElementById("edit_password_new_password_second"))',
                    ]
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

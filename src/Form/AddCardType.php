<?php

namespace App\Form;

use App\Classes\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', HiddenType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantité',
                'required' => true,
                'attr' => [
                    'value' => 1,
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Ajouter au panier',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
            'method' => 'POST',
            'crsf_protection' => true,
        ]);

    }
}

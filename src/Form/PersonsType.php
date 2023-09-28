<?php

// src/Form/PersonsType.php
namespace App\Form;

use App\Entity\Persons;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Imię',
            ])
            ->add('surname', TextType::class, [
                'label' => 'Nazwisko',
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Wiek',
            ])
            ->add('sex', ChoiceType::class, [
                'label' => 'Płeć',
                'choices' => [
                    'Mężczyzna' => 'Mężczyzna',
                    'Kobieta' => 'Kobieta',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Persons::class,
        ]);
    }
}

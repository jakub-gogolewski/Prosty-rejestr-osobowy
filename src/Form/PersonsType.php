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
use Symfony\Component\Validator\Constraints\GreaterThan;

use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\CallbackTransformer;



class PersonsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Imię',
            'constraints' => [
                new Regex([
                    'pattern' => '/^[\p{L}\-\'.]+$/u', // Litery, myślnik i apostrof
                    'message' => 'Imię może zawierać tylko litery, myślnik oraz apostrof.'
                ])
            ]
        ])
        ->add('surname', TextType::class, [
            'label' => 'Nazwisko',
            'constraints' => [
                new Regex([
                    'pattern' => '/^[\p{L}\-\'.]+$/u', // Litery, myślnik i apostrof
                    'message' => 'Nazwisko może zawierać tylko litery, myślnik oraz apostrof.'
                ])
            ]
        ])
        ->add('age', IntegerType::class, [
            'label' => 'Wiek',
            'constraints' => [
                new GreaterThan([
                    'value' => 0,
                    'message' => 'Wiek musi być większy od 0.',
                ]),
                new LessThan([
                    'value' => 150,
                    'message' => 'Wiek musi być mniejszy od 150.',
                ])
            ]
        ])
        ->add('sex', ChoiceType::class, [
            'label' => 'Płeć',
            'choices' => [
                'Mężczyzna' => 'Mężczyzna',
                'Kobieta' => 'Kobieta',
            ]
        ]);


            foreach (['name', 'surname'] as $field) {
                $builder->get($field)->addModelTransformer(new CallbackTransformer(
                    function ($originalName) {
                        return $originalName; // Nie zmieniaj wartości przy wczytywaniu danych z bazy
                    },
                    function ($submittedName) {
                        // Zmieniaj wartość przed zapisem do bazy: każde słowo zaczyna się wielką literą
                        return mb_convert_case($submittedName, MB_CASE_TITLE);
                    }
                ));
            }

            
    }

    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Persons::class,
        ]);
    }
}

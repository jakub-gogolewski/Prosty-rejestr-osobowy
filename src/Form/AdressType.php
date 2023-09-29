<?php

// src/Form/AdressType.php
namespace App\Form;

use App\Entity\Adresses;
use App\Entity\Persons;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\CallbackTransformer;



class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('postal', TextType::class, [
                'label' => 'Kod pocztowy',
                'attr' => ['pattern' => '\d{2}-\d{3}', 'maxlength' => 6],
                'constraints' => [
                    new Regex(['pattern' => '/^\d{2}-\d{3}$/', 'message' => 'Wprowadź poprawny kod pocztowy.'])
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'Miasto',
                'constraints' => [
                    new Regex(['pattern' => '/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ ]+$/', 'message' => 'Miasto może zawierać tylko litery.'])
                ],
            ])
            ->add('street', TextType::class, ['label' => 'Ulica'])
            ->add('street_number', TextType::class, ['label' => 'Numer domu'])
            ->add('flat_number', TextType::class, ['label' => 'Numer mieszkania', 'required' => false]);

        // Transformator do formatowania tekstu dla Miasta i Ulicy
        $builder->get('city')->addModelTransformer(new CallbackTransformer(
            function ($original) {
                return $original;
            },
            function ($submitted) {
                return ucwords(mb_strtolower($submitted));
            }
        ));

        $builder->get('street')->addModelTransformer(new CallbackTransformer(
            function ($original) {
                return $original;
            },
            function ($submitted) {
                return ucwords(mb_strtolower($submitted));
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adresses::class,
        ]);
    }
}
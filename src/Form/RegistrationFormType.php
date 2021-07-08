<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Statut;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Unique;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('pseudo', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un pseudo'
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Votre pseudo doit contenir au moins {{ limit }} caractères'
                    ])
                ]
            ])
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrez votre nom'
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre nom doit être d\'au moins {{ limit }} caractères',
                    ])
                ]
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrez votre prénom'
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre prénom doit être d\'au moins {{ limit }} caractères',
                    ]),
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent être identiques.',
                'options' => ['attr' => ['class' => 'block rounded-full w-full p-2 bg-grey focus:outline-none focus:ring-1 focus:ring-gray-400 focus:border-transparent']],
                'first_options'  => ['label' => 'MOT DE PASSE'],
                'second_options' => ['label' => 'REPETEZ LE MOT DE PASSE'],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'max' => 20,
                        'minMessage' => 'Votre mot de passe doit être d\'au moins {{ limit }} caractères',
                        'maxMessage' => 'Votre mot de passe doit être de moins de {{ limit }} caractères',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'First name',
                'error_bubbling' => true,
                'attr' => [
                    'class' => 'validate',
                    'autofocus' => 1
                ],
                'row_attr' => [
                    'class' => 'input-field col s6'
                ]
            ])
            ->add('lastname', TextType::class, [
                'required' => false,
                'label' => 'Last name',
                'error_bubbling' => true,
                'attr' => [
                    'class' => 'validate'
                ],
                'row_attr' => [
                    'class' => 'input-field col s6'
                ]
            ])
            ->add('username', TextType::class, [
                'label' => 'Username',
                'error_bubbling' => true,
                'attr' => [
                    'class' => 'validate'
                ],
                'row_attr' => [
                    'class' => 'input-field col s12'
                ]
            ])
            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'error_bubbling' => true,
                'invalid_message' => 'The e-mail fields must match.',
                'first_options' => [
                    'label' => 'Active e-mail',
                    'attr' => [
                        'class' => 'validate'
                    ],
                    'row_attr' => [
                        'class' => 'input-field col s6',
                    ]
                ],
                'second_options' => [
                    'label' => 'Repeat e-mail',
                    'attr' => [
                        'class' => 'validate'
                    ],
                    'row_attr' => [
                        'class' => 'input-field col s6'
                    ]
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'mapped' => false,
                'error_bubbling' => true,
                'attr' => [
                    'class' => 'validate'
                ],
                'row_attr' => [
                    'class' => 'input-field col s12'
                ]
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

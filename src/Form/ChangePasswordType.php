<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

/**
 * Defines the custom form field type used to change user's password.
 */
class ChangePasswordType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'error_bubbling' => true,
                'constraints' => [
                    new UserPassword(),
                ],
                'label' => 'Current password',
                'attr'  => [
                    'class' => 'validate',
                    'autocomplete' => 'off'
                ],
                'row_attr' => [
                    'class' => 'input-field col s12'
                ]
            ])

            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'error_bubbling' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 8,
                        'max' => 128,
                    ]),
                ],

                'first_options' => [
                    'label' => 'New password',
                    'attr' => [
                        'class' => 'validate',
                        'autocomplete' => 'off'
                    ],
                    'row_attr' => [
                        'class' => 'input-field col s12'
                    ]
                ],
                
                'second_options' => [
                    'label' => 'Repeat password',
                    'attr' => [
                        'class' => 'validate',
                        'autocomplete' => 'off'
                    ],
                    'row_attr' => [
                        'class' => 'input-field col s12'
                    ]
                ],
            ])
        ;
    }
}

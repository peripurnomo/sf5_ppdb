<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Create your post title',
                'error_bubbling' => true,
                'attr' => [
                    'class' => 'validate',
                    'minlength' => '2',
                    'maxlength' => 255,
                    'autofocus' => 1
                ],
                'row_attr' => [
                    'minlength' => '2',
                    'maxlength' => 1024,
                    'class' => 'input-field col s12'
                ]
            ])

            ->add('body', TextareaType::class, [
                'label' => 'Write your post content',
                'error_bubbling' => true,
                'attr' => [
                    'class' => 'materialize-textarea validate',
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
            'data_class' => Post::class,
        ]);
    }
}

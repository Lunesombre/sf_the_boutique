<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'Veuillez renseigner votre adresse email.',
                    'class' => 'bg-secondary-subtle m-1 ps-1 pe-3 w-100'
                ]
            ])
            ->add(
                'objet',
                TextType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Objet du contact',
                        'class' => 'bg-secondary-subtle m-1 ps-1 pe-3 w-100'
                    ]
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                    'required' => true,
                    'attr' => [
                        'placeholder' => 'Votre message',
                        'class' => 'bg-secondary-subtle m-1 ps-1 pe-3 w-100'
                    ]
                ]
            )
            ->add('Envoyer', SubmitType::class, ['attr' => ['class' => 'bg-success-subtle ms-5']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

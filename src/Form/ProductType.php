<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('HTprice', MoneyType::class, ['currency' => 'EUR', 'label' => 'Prix hors-taxe'])
            ->add('visible', CheckboxType::class, ['required' => false])
            ->add('discount', CheckboxType::class, ['label' => 'Promo', 'required' => false])
            // on enlève ->add('dateCreated') car on ne veut pas pouvoir modifier la date de création de l'article...
            // ->add('category') on l'a enlevé quand on faisait l'edit... On va le remette ne personnalisant lors du create
            ->add('category', EntityType::class, ['class' => Category::class, 'choice_label' => 'name'])
            ->add('submit', SubmitType::class, ['label' => 'Enregistrer']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

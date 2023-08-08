<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('price', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('picture', null, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('date', null, [
                'attr' => ['class' => 'form-control'],
                'widget' => 'single_text'
            ])
            ->add('categorie', null, [
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

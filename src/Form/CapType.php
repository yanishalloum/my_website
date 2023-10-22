<?php

namespace App\Form;

use App\Entity\Cap;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CapType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('name')
            ->add('color')
            ->add('size')
            ->add('condition')
            ->add('brand')
            ->add('year')
            ->add('inventory')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cap::class,
        ]);
    }
}

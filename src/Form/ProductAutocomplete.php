<?php

namespace App\Form;

use App\Entity\Product;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

class ProductAutocomplete extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('product', EntityType::class, [
            'class' => Product::class,
            'placeholder' => 'Recherchez un vélo',
            'choice_label' => 'name',
            'autocomplete' => true,
            'label' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Nom de la catégorie'],
                'label_attr' => ['class' => 'form-label'],
                'label' => 'Nom',
            ])
            ->add('description', null, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Description de la catégorie'],
                'label_attr' => ['class' => 'form-label'],
                'label' => 'Description',
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary mt-3'],
                'label' => 'Valider',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}

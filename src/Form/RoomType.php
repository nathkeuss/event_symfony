<?php

namespace App\Form;

use App\Entity\Establishment;
use App\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false, // Pas de label (géré automatiquement si besoin via form_widget)
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le nom de la salle',
                ],
            ])
            ->add('capacity', IntegerType::class, [
                'label' => false, // Pas de label pour alignement avec form_widget
                'attr' => [
                    'class' => 'form-control mt-3',
                    'placeholder' => 'Entrez la capacité de la salle',
                ],
            ])
            ->add('establishment', EntityType::class, [
                'class' => Establishment::class,
                'choice_label' => 'name',
                'label' => 'Établissement',
                'attr' => [
                    'class' => 'form-control mt-3',
                ],
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-3',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}

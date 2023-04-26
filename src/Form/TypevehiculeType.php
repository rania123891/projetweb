<?php

namespace App\Form;

use App\Entity\Typevehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypevehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nom',
                'label_attr' => ['class' => 'col-sm-2 col-form-label'],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('description', null, [
                'label' => 'Description',
                'label_attr' => ['class' => 'col-sm-2 col-form-label'],
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Typevehicule::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('immatriculation', null, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Immatriculation',
                'label_attr' => ['class' => 'col-sm-6 col-form-label'],
            ])
            ->add('marque', null, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Marque',
                'label_attr' => ['class' => 'col-sm-2 col-form-label'],
            ])
            ->add('puissance', null, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Puissance',
                'label_attr' => ['class' => 'col-sm-2 col-form-label'],
            ])
            ->add('kilometrage', null, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Kilométrage',
                'label_attr' => ['class' => 'col-sm-2 col-form-label'],
            ])
            ->add('nbrdeplace', null, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Nombre de places',
                'label_attr' => ['class' => 'col-sm-2 col-form-label'],
            ])
            ->add('prix', null, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Prix',
                'label_attr' => ['class' => 'col-sm-2 col-form-label'],
            ])
            ->add('typeVehicule', null, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Type de véhicule',
                'label_attr' => ['class' => 'col-sm-2 col-form-label'],
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}

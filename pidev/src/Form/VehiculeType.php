<?php

namespace App\Form;

use App\Entity\Vehicule;
use App\Entity\Typevehicule;

use App\Repository\AgenceRepository;
use App\Repository\TypevehiculeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class VehiculeType extends AbstractType
{
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();
         $agences = $user->getAgences();
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
            // ->add('typeVehicule', null, [
            //     'attr' => ['class' => 'form-control'],
            //     'label' => 'Type de véhicule',
            //     'label_attr' => ['class' => 'col-sm-2 col-form-label'],
            // ])
            ->add('typeVehicule',null, [
                'class' => Typevehicule::class,
                'query_builder' => function (TypevehiculeRepository $er) use ($agences) {
                    return $er->createQueryBuilder('tv')
                        ->join('tv.agence', 'a')
                        ->andWhere('a IN (:agences)')
                        ->setParameter('agences', $agences);
                },
                'choice_label' => 'nom',
                'label' => 'Type de véhicule',
                'attr' => ['class' => 'form-control'],
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

<?php

namespace App\Form;

use App\Entity\Typevehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TypevehiculeType extends AbstractType
{
    public function __construct(Security $security)
{
    $this->security = $security;
}
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();

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
            ->add('agence', ChoiceType::class, [
                'choices' => $user->getAgences(),
                'choice_label' => function ($agence) {
                    return $agence->getNomAg();
                },
                'label' => 'Agence',
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

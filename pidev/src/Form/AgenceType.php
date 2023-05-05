<?php

namespace App\Form;

use App\Entity\Agence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Reservation;
use Symfony\Component\Validator\Constraints\NotBlank;

class AgenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomAg', null, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('NombreAg', null, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('RefAg', null, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('EmailAg', null, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('AdresseAg', null, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('VilleAg', null, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agence::class,
        ]);
    }
}


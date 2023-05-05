<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', null, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez saisir une adresse email.',
                ]),
            ],
        ])
        ->add('prenom', null, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez saisir votre prénom.',
                ]),
            ],
        ])            ->add('nom', null, [
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez saisir votre nom.',
                ]),
            ],
        ])
            ->add('numTel', TelType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un numéro de téléphone.',
                    ]),
                    new Regex([
                        'pattern' => '/^[0-9]{8}$/',
                        'message' => 'Veuillez saisir un numéro de téléphone valide (8 chiffres).',
                    ]),
                ],
            ])
            ->add('adresse', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre nom.',
                    ]),
                ],
            ])
            ->add('description', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre nom.',
                    ]),
                ],
            ])
            ->add('file')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
                "label" => "Adresse email",
                "attr" => [
                    "autofocus" => true,
                ]

            ])
            ->add('pseudo', null, [
                "label" => "Mon pseudo"
            ])
            ->add('aboutUser', null, [
                "label" => "À propos de moi"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}

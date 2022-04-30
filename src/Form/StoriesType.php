<?php

namespace App\Form;

use App\Entity\Tags;
use App\Entity\Stories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                "label" => "Le titre de l'histoire",
                "row_attr" => ["class" => "col-4"],
            ])
            ->add('description', null, [
                "label" => "Le contenu de votre histoire"
            ])
            ->add('tags', EntityType::class, [
                "label" => "Choisissez les catégories associées",
                // looks for choices from this entity
                'class' => Tags::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'name',
            
                // used to render a select box, check boxes or radios
                'multiple' => true,
                // 'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stories::class,
        ]);
    }
}

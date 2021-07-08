<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use App\Entity\Calendar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre ',
            ])
            ->add('start', DateTimeType::class, [
                'date_widget' => 'single_text',
                'label' => 'Début ',
            ])
            ->add('end', DateTimeType::class, [
                'date_widget' => 'single_text',
                'label' => 'Fin ',
            ])
            ->add('description', null, [
                'label' => 'Description ',
            ])
            ->add('all_day', CheckboxType::class, [
                'label' => 'Toute la journée ',
                'required' => false,
            ] )
            ->add('background_color', ColorType::class, [
                'label' => 'Couleur de fond ',
            ])
            ->add('text_color', ColorType::class, [
                'label' => 'Couleur de texte '
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Calendar::class,
        ]);
    }
}

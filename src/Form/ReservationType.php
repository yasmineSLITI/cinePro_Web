<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Evenement;
use App\Entity\Film;
use App\Entity\Salle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categorie',ChoiceType::class, [
                'choices'  => [
                    'Film' => 'Film',
                    'Evénement' => 'Evénement',
                    
                ],
            ])
            ->add('nbplace',TextType::class,[
                'label'=>'Nombre de place'
            ])
            ->add('datedeb',TextType::class,[
                'label'=>'Date début'
            ])
            ->add('datefin',TextType::class,[
                'label'=>'Date Fin'
            ])
            ->add('idev',
            EntityType::class,
            ['label'=>'Evenement','class'=>Evenement::class,
                'choice_label'=>'nomEv','multiple'=>false,'expanded'=>false])
            ->add('idf',
            EntityType::class,
            ['label'=>'Film','class'=>Film::class,
                'choice_label'=>'nomF','multiple'=>false,'expanded'=>false])
            ->add('idsa',
            EntityType::class,
            ['label'=>'Salle','class'=>Salle::class,
                'choice_label'=>'nomSalle','multiple'=>false,'expanded'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}

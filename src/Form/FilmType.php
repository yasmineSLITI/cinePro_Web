<?php

namespace App\Form;

use App\Entity\Film;
use App\Entity\Realisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormTypeInterface;
class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            ->add('nomf',TextType::class,[
                'label'=>'Nom du film'
            ])
            ->add('genre')
            
            ->add('image',FileType::class,[
                'label' => "insérer une image",
                'multiple' => true,
                'mapped' => false,
                'required' => false
               
            ])
            ->add('description' ,TextType::class)
            ->add('duree',TextType::class,[
                'label'=>'Durée'
            ])
            
           
            ->add('numrea',
            EntityType::class,
            ['label'=>'nom de lorganisation','class'=>Realisateur::class,
                'choice_label'=>'nomorg','multiple'=>false,'expanded'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
            'csrf_protection'=>true,
            'csrf_field_name'=>'_token',
            'csrf_token_id'=>'subscriber_item'

        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Publication;
use App\Repository\PublicationRepository;

use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('titre',TextType::class,[
            'label'=>"titre",
            'attr'=>[
                "placeholder"=>"add titre",
                'class'=>"form-control"
            ]
        ])


        
        ->add('imgpub',FileType::class,[
            'label'=> 'insert image',
            'required'=> false,
            'data_class'=> null,
            'mapped'=> true
           
            
        ])


        
        ->add('txtpub',TextType::class,[
            'label'=>"description",
            'attr'=>[
                "placeholder"=>"add description",
                'class'=>"form-control"
            ]
            ]);
        
            
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}

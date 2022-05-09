<?php

namespace App\Form;

use App\Entity\Compte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class CompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('Nom')
            ->add('Prenom')
            ->add('mail')
            ->add('password', PasswordType::class)
            ->add('confirm_password', PasswordType::class)
            ->add('roles',ChoiceType::class,['choices'=> 
            ['Sponsor'=>'ROLE_SPONSOR','Administrateur'=>'ROLE_ADMIN','presse'=>'ROLE_PRESSE','Realisateur'=>'ROLE_REALISATEUR','Client'=>'ROLE_CLIENT']
        ,'multiple'=>true,'expanded'=>true,'label'=>'Roles'
    ])
            ->add('image', FileType::class,[
                'label' => "insérer une image",
                'data_class'=> null,
                'mapped' => true,
                'required' => false])
            ->add('Valider',SubmitType::class )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Compte::class,
        ]);
    }
}

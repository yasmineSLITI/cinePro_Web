<?php

namespace App\Form;

use App\Entity\Demandedesponsoring;
use App\Entity\Evenement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class DemandedesponsoringType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('description')
            ->add('paquet', ChoiceType::class, [
                'choices' => [
                    'Bronze' => "Bronze",
                    'Silver' => "Silver",
                    'Gold' => "Gold",
                ],]);
    }
    

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demandedesponsoring::class,
        ]);
    }
}

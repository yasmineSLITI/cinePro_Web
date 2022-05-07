<?php

namespace App\Form;

use App\Entity\Billet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class BilletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categoriebillet', ChoiceType::class, [
                'choices'  => [
                    'First Class' => 'First Class',
                    'Second Class' => 'Second Class',
                    'Third Class' => 'Third Class',
                ],
            ])
            ->add('nbPlace', IntegerType::class, array(

                'attr' => array(
                    'placeholder' => 'Veuillez Entrer Le Nombre de Place'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Billet::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation', TextType::class, array(
                'label' => 'Désignation',
                'attr' => array(
                    'placeholder' => 'Veuillez Entrer la désignation du produit'
                )
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Déscription',
                'attr' => array(
                    'placeholder' => 'Veuillez Entrer la déscription du produit'
                )
            ))

            ->add('image', FileType::class, array(
                'required' => false,
                'data_class' => null,
                'mapped' => true,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Le fichier n\'est pas valide, assurez vous d\'avoir un fichier au format PNG, JPG, JPEG)',
                    ]),
                ]
            ))
            ->add('quantiteenstock', IntegerType::class, array(

                'attr' => array(
                    'placeholder' => 'Veuillez Entrer la Quantité En Stock du produit'
                )
            ))
            ->add('prixachatunit', NumberType::class, array(

                'attr' => array(
                    'placeholder' => "Veuillez Entrer le prix d'achat unitaire du produit"
                )
            ))
            ->add('prixventeunit', NumberType::class, array(

                'attr' => array(
                    'placeholder' => "Veuillez Entrer le prix de vente unitaire du produit"
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Figure;
use App\Entity\FigureGroupe;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FigureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => array(
                    'class'=>''
                ),
                'label'=>'Nom de la figure :'
            ])
            ->add('description', TextareaType::class, [
                'attr' => array(
                    'class'=>''
                ),
                'label'=>'Description de la figure :'
            ])
            ->add('groupe', EnumType::class, [
                'attr' => array(
                    'class'=>''
                ),
                'label'=>'Groupe de figure :',
                'class' => FigureGroupe::class,
                'choice_label' => fn ($choice) => match ($choice) {
                    FigureGroupe::slides => 'slides',
                    FigureGroupe::sauts => 'sauts',
                    FigureGroupe::rotationsDesaxees => 'rotations désaxées',
                    FigureGroupe::rotations => 'rotations',
                    FigureGroupe::oneFootTricks => 'one foot tricks',
                    FigureGroupe::oldSchool => 'old school',
                    FigureGroupe::grabs => 'grabs',
                    FigureGroupe::flips => 'flips',
                    FigureGroupe::barreDeSlide => 'barre de slide',
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class MediaFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('media_path', FileType::class, [
                'required' => true,
                'constraints' => [new Image([
                    'extensions' => ['jpeg', 'jpg', 'png', 'webp'],
                    'extensionsMessage' => 'Merci de télécharger une image au bon format (png,jpeg,jpg).'
                ])],
                'mapped' => false,
                'attr' => array(
                    'class' => '',
                    'accept' => 'image/*'
                ),
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}

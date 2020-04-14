<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Track;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TrackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('trackNumber')
            ->add('trackFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => false, 
                'download_uri' => true,
                'download_label' => static function (Track $track) {
                    return 'download '.$track->getTitle();
                },
                'asset_helper' => true,
                'label' => 'Choose file to upload',
            ])
            ->add('album', EntityType::class,[
                'class' => Album::class,
                'choice_label' => 'title'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Track::class,
        ]);
    }
}

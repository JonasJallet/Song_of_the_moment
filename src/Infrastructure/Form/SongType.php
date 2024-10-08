<?php

namespace App\Infrastructure\Form;

use App\Infrastructure\Persistence\Entity\Song;
use App\Infrastructure\Service\LinkYoutubeFormat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SongType extends AbstractType
{
    private LinkYoutubeFormat $linkYoutubeFormat;

    public function __construct(LinkYoutubeFormat $linkYoutubeFormat)
    {
        $this->linkYoutubeFormat = $linkYoutubeFormat;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'attr' =>
                    [
                        'placeholder' => 'Ex : All Along the Watchtower',
                        'class' => 'form-control'
                    ],
                    'label' => 'Titre de la chanson',
                    'label_attr' =>
                    [
                        'class' => 'form-label'
                    ]
                ]
            )

            ->add(
                'artist',
                TextType::class,
                [
                    'attr' =>
                    [
                        'placeholder' => 'Ex : Jimi Hendrix',
                        'class' => 'form-control'
                    ],
                    'label' => 'Artiste',
                    'label_attr' =>
                    [
                        'class' => 'form-label'
                    ]
                ]
            )

            ->add(
                'album',
                TextType::class,
                [
                    'attr' =>
                    [
                        'placeholder' => 'Ex : Electric Ladyland',
                        'class' => 'form-control'
                    ],
                    'label' => 'Album',
                    'label_attr' =>
                    [
                        'class' => 'form-label'
                    ]
                ]
            )

            ->add(
                'photo_album',
                TextType::class,
                [
                    'attr' =>
                    [
                        'placeholder' => 'Ex : https://www.pochettealbum.jpg',
                        'class' => 'form-control'
                    ],
                    'label' => 'Lien Image Pochette Album',
                    'label_attr' =>
                    [
                        'class' => 'form-label'
                    ]
                ]
            )

            ->add(
                'link_youtube',
                TextType::class,
                [
                    'attr' =>
                    [
                        'placeholder' => 'Ex : https://www.youtube.com/watch?v=TLV4_xaYynY',
                        'class' => 'form-control'
                    ],
                    'label' => 'Lien Youtube',
                    'label_attr' =>
                    [
                        'class' => 'form-label'
                    ],
                    'empty_data' => '',
                ]
            );

        $builder->get('link_youtube')->addModelTransformer(new CallbackTransformer(
            function ($value) {
                return $value ? 'https://www.youtube.com/watch?v=' . $this->linkYoutubeFormat->format($value) : '';
            },
            function ($value) {
                return $value ? $this->linkYoutubeFormat->format($value) : '';
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Song::class,
        ]);
    }
}

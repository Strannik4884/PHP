<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichFileType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'constraints' => [
                    new Length([
                        'max' => 255
                    ]),
                    new NotBlank([
                        'message' => 'Введите название книги!'
                    ])
                ],
                'label' => 'Название',
                'attr' => [
                    'class' => 'validate'
                ]
            ])
            ->add('author', null, [
                'constraints' => [
                    new Length([
                        'max' => 255
                    ]),
                    new NotBlank([
                        'message' => 'Введите автора книги!'
                    ])
                ],
                'label' => 'Автор',
                'attr' => [
                    'class' => 'validate'
                ]
            ])
            ->add('bookPhotoFile', VichFileType::class, array('allow_delete' => false))
            ->add('bookFileFile', VichFileType::class,  array('allow_delete' => false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}

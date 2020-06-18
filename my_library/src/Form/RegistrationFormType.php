<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [
                    new Email([
                        'message' => 'Некорректный Email.'
                    ]),
                    new Length([
                        'max' => 255
                    ])
                ],
                'label' => 'Email',
                'attr' => [
                    'class' => 'validate'
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'required' => true,
                'mapped' => false,
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Пароль должен быть не менее {{ limit }} символов.',
                        'max' => 255
                    ]),
                    new Regex([
                        'pattern' => '/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z!@#$%^&*]{6,}/',
                        'message' => 'Пароль должен состоять из латинских заглавных и строчных букв, содержать цифры и символы !@#$%^&*'
                    ])
                ],
                'first_options'  => [
                    'label' => 'Пароль',
                    'attr' => [
                        'class' => 'validate'
                    ]
                ],
                'second_options' => [
                    'label' => 'Повторите пароль',
                    'attr' => [
                        'class' => 'validate'
                    ]
                ],
                'invalid_message' => 'Пароли не совпадают.'
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'required' => true,
                'mapped' => false,
                'attr' => [
                    'class' => 'filled-in'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

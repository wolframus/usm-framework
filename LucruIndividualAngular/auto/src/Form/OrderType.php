<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\Status;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client', TextType::class, [
                'label' => "Client",
                'label_attr' => ['class' => 'text-gray-700'],
                'attr' => ['class' => 'bg-blue-200 border border-blue-300 p-2 mt-1 focus:ring-1 focus:ring-blue-400 focus:outline-0 rounded-md w-full'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Camp Obligatoriu',
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Min. length of field: {{ limit }}',
                        'maxMessage' => 'Max. length of field: {{ limit }}',
                    ])
                ]
            ])
            ->add('adress', TextType::class, [
                'label' => "Adresa",
                'label_attr' => ['class' => 'text-gray-700'],
                'attr' => ['class' => 'bg-blue-200 border border-blue-300 p-2 mt-1 focus:ring-1 focus:ring-blue-400 focus:outline-0 rounded-md w-full'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Camp Obligatoriu',
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Min. length of field: {{ limit }}',
                        'maxMessage' => 'Max. length of field: {{ limit }}',
                    ])
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => "Telefon",
                'label_attr' => ['class' => 'text-gray-700'],
                'attr' => ['class' =>  'bg-blue-200 border border-blue-300 p-2 mt-1 focus:ring-1 focus:ring-blue-400 focus:outline-0 rounded-md w-full'],
                'constraints' => [
                    new Regex([
                        'pattern' =>  '/^\+?0?(6|7)(0|6|7|8)([0-9]){6}$/',
                        'message' => 'Telefon gresit',
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => "e-mail",
                'label_attr' => ['class' => 'text-gray-700'],
                'attr' => ['class' =>  'bg-blue-200 border border-blue-300 p-2 mt-1 focus:ring-1 focus:ring-blue-400 focus:outline-0 rounded-md w-full'],
                'invalid_message' => 'Your email is invalid',
            ])
            ->add('status', EntityType::class, [
                'label' => "Statut",
                'class' => Status::class,
                'choice_value' => 'id',
                'choice_label' => 'fullName',
                'label_attr' => ['class' => 'text-gray-700'],
                'attr' => ['class' => 'block w-full bg-blue-200 focus:outline-0 border border-blue-300 text-gray-900 rounded-lg cursor-pointer p-2'],
            ])
            ->add('save', SubmitType::class, [
                'label' => "Salveaza",
                'attr' => ['class' => 'bg-blue-500 leading-none  text-white p-[14px] rounded-lg  border border-blue-300 hover:ring-2 hover:ring-blue-300'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}

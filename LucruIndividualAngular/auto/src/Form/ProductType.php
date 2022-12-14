<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Type',
                'required' => true,
                'label_attr' => ['class' => 'text-gray-700'],
                'attr' => ['class' => 'bg-blue-200 border border-blue-300 p-2 mt-1 focus:ring-1 focus:ring-blue-400 focus:outline-0 rounded-md w-full'],
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Min. length of field: {{ limit }}',
                        'maxMessage' => 'Max. length of field: {{ limit }}',
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => true,
                'label_attr' => ['class' => 'text-gray-700'],
                'attr' => ['class' => 'bg-blue-200 border border-blue-300 p-2 mt-1 focus:ring-1 focus:ring-blue-400 focus:outline-0 rounded-md w-full'],
                'constraints' => [
                    new Length([
                        'min' => 4,
                        'max' => 1000,
                        'minMessage' => 'Min. length of field: {{ limit }}',
                        'maxMessage' => 'Max. length of field: {{ limit }}',
                    ])
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Cost',
                'label_attr' => ['class' => 'text-gray-700'],
                'attr' => ['class' =>  'bg-blue-200 border border-blue-300 p-2 mt-1 focus:ring-1 focus:ring-blue-400 focus:outline-0 rounded-md w-full'],
                'required' => true,
                'constraints' => ([
                    new Type([
                        'type' => 'double',
                        'message' => 'You entered invalid value',
                    ]),
                    new Range([
                        'min' => 1,
                        'max' => 100000,
                        'notInRangeMessage' => 'You must be between {{ min }} and {{ max }}',
                    ])
                ])
            ])
            ->add('image', FileType::class, [
                'label' => 'Photo',
                'mapped' => false,
                'required' => false,
                'label_attr' => ['class' => 'text-gray-700'],
                'attr' => ['class' => 'block w-full bg-blue-200 border border-blue-300 focus:outline-0 text-gray-900 rounded-lg cursor-pointer  file:p-2 file:border-0 file:text-gray-800 file:bg-blue-300'],
                'constraints' => ([
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/svg+xml',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PNG, JPEG or SVG document',
                    ])
                ])
            ])
            ->add('category', EntityType::class, [
                'label' => 'Category',
                'label_attr' => ['class' => 'text-gray-700'],
                'attr' => ['class' => 'block w-full bg-blue-200 focus:outline-0 border border-blue-300 text-gray-900 rounded-lg cursor-pointer p-2'],
                'class' => Category::class,
                'choice_value' => 'id',
                'choice_label' => 'name',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'SAVE',
                'attr' => ['class' => 'bg-blue-500 leading-none  text-white p-[14px] rounded-lg  border border-blue-300 hover:ring-2 hover:ring-blue-300'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

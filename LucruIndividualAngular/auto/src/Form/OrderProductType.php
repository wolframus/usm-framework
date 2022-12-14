<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Query\Expr\Orx;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class OrderProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ord', EntityType::class, [
                'label' => 'Selecteaza comanda',
                'choice_value' => 'id',
                'choice_label' => 'id',
                'class' => Order::class,
                'label_attr' => ['class' => 'text-gray-700'],
                'attr' => ['class' => 'block w-full bg-blue-200 focus:outline-0 border border-blue-300 text-gray-900 rounded-lg cursor-pointer p-2'],
            ])
            ->add('count', IntegerType::class, [
                'label_attr' => ['class' => 'text-gray-700'],
                'attr' => ['class' =>  'bg-blue-200 border border-blue-300 p-2 mt-1 focus:ring-1 focus:ring-blue-400 focus:outline-0 rounded-md w-full'],
                'label' => 'Set count',
                'constraints' => [
                    new Type([
                        'type' => 'integer',
                        'message' => 'You entered invalid count',
                    ]),
                    new NotBlank([
                        'message' => 'This field is required',
                    ])
                ]
            ])
            ->add('add_count', CheckboxType::class, [
                'label_attr' => ['class' => 'text-gray-700'],
                'label' => 'Adauga',
                'required' => false,
                'mapped' => false,
            ])
            ->add('product', EntityType::class, [
                'label' => 'Produs',
                'class' => Product::class,
                'choice_value' => 'id',
                'choice_label' => 'name',
                'label_attr' => ['class' => 'text-gray-700'],
                'attr' => ['class' => 'block w-full bg-blue-200 focus:outline-0 border border-blue-300 text-gray-900 rounded-lg cursor-pointer p-2'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Salveaza',
                'attr' => ['class' => 'bg-blue-500 leading-none  text-white p-[14px] rounded-lg  border border-blue-300 hover:ring-2 hover:ring-blue-300'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderProduct::class,
        ]);
    }
}

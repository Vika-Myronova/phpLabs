<?php

namespace App\Form;

use App\Entity\Reader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReaderFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'required' => false,
                'label' => 'Full Name',
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'label' => 'Email',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Видаляємо data_class, щоб форма повертала лише масив
        $resolver->setDefaults([
            'data_class' => null, // Тепер не буде повертати об'єкт Reader
        ]);
    }
}
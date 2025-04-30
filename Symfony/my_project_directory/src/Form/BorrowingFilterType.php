<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Reader;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BorrowingFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('borrowDateFrom', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Позичено від',
            ])
            ->add('borrowDateTo', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Позичено до',
            ])
            ->add('returnDateFrom', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Повернуто від',
            ])
            ->add('returnDateTo', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
                'label' => 'Повернуто до',
            ])
            ->add('book', EntityType::class, [
                'class' => Book::class,
                'choice_label' => 'title',
                'required' => false,
                'placeholder' => 'Усі книги',
            ])
            ->add('reader', EntityType::class, [
                'class' => Reader::class,
                'choice_label' => 'full_name',
                'required' => false,
                'placeholder' => 'Усі читачі',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }

}
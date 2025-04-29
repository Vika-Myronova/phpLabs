<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Borrowing;
use App\Entity\Reader;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BorrowingForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('borrowDate')
            ->add('returnDate')
            ->add('book', EntityType::class, [
                'class' => Book::class,
                'choice_label' => 'title',
            ])
            ->add('reader', EntityType::class, [
                'class' => Reader::class,
                'choice_label' => 'fullName',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Borrowing::class,
        ]);
    }
}

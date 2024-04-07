<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('gender', EnumType::class, [
            'required' => true,
        ]);
        $builder->add('age', IntegerType::class, [
            'label' => 'Vecums',
            'required' => true,
            'attr' => [
                'min' => 0,
                'max' => 100,
            ],
        ]);
        $builder->add('submit', SubmitType::class, [
            'mapped' => false,
            'label' => 'Saglabāt',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
        ]);
    }
}

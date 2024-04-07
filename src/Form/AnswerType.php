<?php

declare(strict_types=1);

namespace App\Form;

use App\Enum\Gender;
use App\Messenger\Command\StartAnswer;
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
            'class' => Gender::class,
            'label' => 'Dzimums',
            'placeholder' => '',
        ]);
        $builder->add('age', IntegerType::class, [
            'label' => 'Vecums',
            'required' => true,
            'attr' => [
                'min' => 1,
                'max' => 100,
                'step' => 1,
            ],
        ]);
        $builder->add('submit', SubmitType::class, [
            'label' => 'Saglabāt',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StartAnswer::class,
        ]);
    }
}

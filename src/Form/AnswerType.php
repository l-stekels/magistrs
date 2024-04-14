<?php

declare(strict_types=1);

namespace App\Form;

use App\Enum\Education;
use App\Enum\Gender;
use App\Enum\Hobby;
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
        $builder->add('education', EnumType::class, [
            'label' => 'Izglītība',
            'required' => true,
            'placeholder' => '',
            'class' => Education::class,
            'choice_label' => fn(Education $education) => $education->value,
        ]);
        $builder->add('hobbies', EnumType::class, [
            'label' => 'Hobiji',
            'required' => false,
            'multiple' => true,
            'expanded' => true,
            'class' => Hobby::class,
            'choice_label' => fn(Hobby $hobby) => $hobby->value,
            'help' => 'Izvēlaties vienu vai vairākus brīvā laika pavadīšanas veidus, ar kuriem Jūs nodarbojaties.',
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

<?php

declare(strict_types=1);

namespace App\Form;

use App\Messenger\Command\CreateTest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('title', TextType::class, [
            'required' => true,
            'label' => 'Nosaukums',
        ]);
        $builder->add('isEyeTracking', CheckboxType::class, [
            'label' => 'Skatiena pārneses eksperiments',
        ]);
        $builder->add('isShared', CheckboxType::class, [
            'label' => 'Redzams visiem',
            'required' => false,
        ]);
        $builder->add('submit', SubmitType::class, [
            'label' => 'Saglabāt',
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateTest::class,
        ]);
    }
}

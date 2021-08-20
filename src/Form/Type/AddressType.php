<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Address;

use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('anrede', ChoiceType::class, [
                'choices' => [
                'Herr' => 0,
                'Frau' => 1,
                'Dr.' => 2,
                'Prof.' => 3,],
            'attr' => ['class' => 'form-select'],
            ])
            ->add('vorname', TextType::class, [
            'attr' => ['class' => 'form-control'],
            ])
            ->add('nachname', TextType::class, [
            'attr' => ['class' => 'form-control'],
            ])
            ->add('strasse', TextType::class, [
            'attr' => ['class' => 'form-control'],
            'label' => 'Straße',
            ])
            ->add('hausnummer', TextType::class, [
            'attr' => ['class' => 'form-control'],
            ])
            ->add('plz', TextType::class, ['attr' => [
            'class' => 'form-control'],
            ])
            ->add('ort', TextType::class, [
            'attr' => ['class' => 'form-control'],
            ])
            ->add('geburtsdatum', BirthdayType::class, [
            'required' => false,
            'widget' => 'single_text',
            'attr' => ['class' => 'form-control',],
            ])
            ->add('telefon', TelType::class, [
            'attr' => ['class' => 'form-control'],
            'required' => false,
            ])
            ->add('email', EmailType::class, [
            'attr' => ['class' => 'form-control'],
            'required' => false,
            ])
            ->add('Speichern', SubmitType::class, ['attr' => ['class' => 'btn btn-primary'],]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}

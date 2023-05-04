<?php

namespace App\Form;


use App\Entity\Doctor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DoctorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'noù'
            ])
            ->add('cin', TextType::class, [
                'label' => 'cin'
            ])
            ->add('prenom', EmailType::class, [
                'label' => 'prenom'
            ])
            ->add('email', EmailType::class, [
                'label' => 'email'
            ])
            ->add('specialite', EmailType::class, [
                'label' => 'specialite'
            ])
            ->add('adresse', TextType::class, [
                'label' => 'adresse'
            ])
            ->add('diplome', TextType::class, [
                'label' => 'diplome'
            ])
            ->add('password', TextType::class, [
                'label' => 'password'
            ])
            ->add('age', TextType::class, [
                'label' => 'age'
            ])
           
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class)
            ->add('save', SubmitType::class, [
                'label' => 'Add'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Doctor::class,
        ]);
    }
}

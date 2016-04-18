<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('birthDate', DateTimeType::class,
                array(
                    'html5' => false, 
                    'widget' => 'single_text',
                    //'format' => 'dd/MM/yyyy',
                    'attr' => array('readonly' => 'radonly')));
        
        $builder->add('sex', ChoiceType::class, 
                    array(
                        'choices' => array(
                        0 => 'Male',
                        1 => 'Female')
                    )
                );
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
    
    public function getBirthDate()
    {
        return $this->$this->getBlockPrefix();
    }
}
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

/**
 * Description of EventType
 *
 * @author rmroz
 */
class EventType extends AbstractType {
    
    
    //nazwę, miejsce, opis, datę i godzinę, czas trwania, maksymalną liczbę gości, 
    //datę końca zbierania zgłoszeń, mogę zaznaczyć na mapie Google'a miejsce spotkania oraz zaznaczyć czy event jest publiczny czy prywatny
    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('event_name', TextType::class, array('label' => 'Name'))
                
                ->add('event_location', TextType::class, array('label' => 'Location', 'data' => \AppBundle\Entity\Event::DEFAAULT_CITY))
                
                ->add('event_description', TextareaType::class, array('label' => 'Description'))
                
                ->add('event_start', DateTimeType::class, [
                                        'widget' => 'single_text',
                                        'format' => 'dd/MM/yyyy HH:mm',
                                        'data'   => new \DateTime()
                                    ])
                
                ->add('event_duration', TextType::class, array('label' => 'Duration'))
                
                ->add('event_max_users', TextType::class, array('label' => 'Max Users'))
                
                ->add('event_invitations_end', DateTimeType::class, [
                                        'widget' => 'single_text',
                                        'format' => 'dd/MM/yyyy HH:mm',
                                        'label'  => 'Invitations end',
                                        'data'   => new \DateTime()
                                    ])
                
                ->add('event_type', ChoiceType::class, array('choices' => array(0 => 'Public',1 => 'Private')))
                ->add('event_lat', NumberType::class, 
                        array('scale' => 12, 'data' => \AppBundle\Entity\Event::DEFAULT_LAT,'precision' => 18, 'label' => 'Lat', 'attr' => array('readonly' => 'readonly')))
                
                ->add('event_lng', NumberType::class, 
                        array('scale' => 12, 'data' => \AppBundle\Entity\Event::DEFAULT_LNG, 'precision' => 18, 'label' => 'Lng', 'attr' => array('readonly' => 'readonly')));

    }

    public function setDefaultOptions(\Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver) {
        parent::setDefaultOptions($resolver);
    }

    
}

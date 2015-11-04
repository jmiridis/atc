<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('destination')
            ->add('roundTrip', 'choice', array(
                'expanded' => true,
                'choices' => array(
                    'OW' => 'one way',
                    'RT' => 'round trip'
                )
            ))
            ->add('noPax')
            ->add('hotel')
            ->add('arrivalDate')
            ->add('arrivalFlightNo')
            ->add('departureDate')
            ->add('departureFlightNo')
            ->add('comment')
            ->add('client', new ClientType(), array('data_class' => 'AppBundle\Entity\Client'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Reservation'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_reservation';
    }
}
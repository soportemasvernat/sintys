<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('username')
            ->add('email')
            ->add('plainPassword', 'text', array(
                'required' => false,
            ))
            ->add('organismos')
            ->add('rol', 'choice', array(
                'choices' => array('ROLE_USER' => 'Usuario', 'ROLE_ADMIN' => 'Admin'),
                'multiple' => false,
                'mapped' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }
}

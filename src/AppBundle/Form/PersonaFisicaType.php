<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonaFisicaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idPersona')
            ->add('deno')
            ->add('tdoc')
            ->add('ndoc')     
            ->add('fnac', 'date', array(
                'widget' => 'single_text'
            ))
            ->add('sexo')
            //->add('coberturas')
            ->add('obraSocialNombre', 'text', array(
                'mapped' => false,
            ))
            ->add('obraSocialCodigo', 'text', array(
                'mapped' => false,
            ))
            ->add('obraSocialPeriodo', 'text', array(
                'mapped' => false,
            ))
            ->add('obraSocialBaseOrigen', 'text', array(
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
            'data_class' => 'AppBundle\Entity\PersonaFisica'
        ));
    }
}

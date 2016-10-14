<?php
namespace AppBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;

class ConsultaType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		
			
		$builder
		->add('deno', 'text', array(
			'label' => 'Apellido y nombre',
			'required' => false
			
		))
		->add('ndoc', 'number', array(
			'label' => 'Numero de documento',
			'required' => false
			
		))
        ->add('tematicas','choice', array(
  			'choices' => array(
  			'SI' => 'SI', 
  			'NO' => 'NO'),
  			'label' => 'Busca coberturas??'
		))

	 ->add('organismo','entity', array(
             'label'=>'Escoja su Organismo',
             'class' => 'AppBundle:Organismo',
             'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('o')
                            ->orderBy('o.nombre','DESC')
                            ;
                },
                
            ))

           		
		->add('consultar', 'submit', array(
			'label' => 'Consulta',
		))

		;
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
		));
	}
	public function getName()
	{
	return 'consulta';
	}
}
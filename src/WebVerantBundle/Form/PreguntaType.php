<?php

namespace WebVerantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreguntaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text',array(
                'max_length' => 50,
                'label' => 'Nombre',                
                'label_attr' => array('class' => 'input'),
                'attr' => array('class' => 'form-control')
            ))
                
            ->add('email', 'email', array(
                'max_length' => 255,
                
                'label_attr' => array('class' => 'input'),
                'attr' => array('class' => 'form-control')
            ))
                
            ->add('pregunta','textarea', array(
                'max_length' => 500,
                'required' => false,
                'label_attr' => array('class' => 'input'),
                'attr' => array('class' => 'form-control')
                ))
                
                
            ->add('isActive', 'hidden', array('data' => true))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WebVerantBundle\Entity\Pregunta'
        ));
    }
}

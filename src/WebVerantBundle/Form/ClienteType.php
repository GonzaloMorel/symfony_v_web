<?php

namespace WebVerantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;

class ClienteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo','text',array(
                'max_length' => 50,
                'label' => 'Nombre Empresa',
                'attr' => array('class' => 'form-control')
                ))
                
                           
            ->add('imagen', 'file', array(
                'required' => false,
                'data_class'=> null,                
                'attr' => array('class' => 'custom-file-upload', 'id' => 'file', 'data-btn-text' => "Seleccione un Archivo")
                ))
            
            ->add('despliegue','hidden', array(
                'data' => 'ABOUT'
            ))    
            
            ->add('posicion','hidden', array(
                'data' => 'CLIENTE'
            ))
            
             
            ->add('isActive', 'checkbox',array(
                'label' => 'Activo'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WebVerantBundle\Entity\Contenido'
        ));
    }
}

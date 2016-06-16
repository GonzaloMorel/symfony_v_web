<?php

namespace WebVerantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array(
                'max_length' => 255,
                'attr' => array('class' => 'form-control')
            ))
            ->add('email','email', array(
                'max_length' => 255,
                'attr' => array('class' => 'form-control')
            ))
            ->add('telefono','integer',array(
                'scale' => 0,
                'label' => 'Teléfono',
                'attr' => array('class' => 'form-control')
                ))
            ->add('asunto','text', array(
                'max_length' => 255,
                'attr' => array('class' => 'form-control')
            ))
            ->add('mensaje','textarea', array(
                'max_length' => 500,
                'required' => false,
                'attr' => array('class' => 'summernote form-control')
                ))
            ->add('archivo','file', array(
                'required' => false,
                'data_class'=> null,
                'attr' => array('class' => 'custom-file-upload')
                ))
            ->add('isActive','hidden', array('data' => true))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WebVerantBundle\Entity\Contacto'
        ));
    }
}

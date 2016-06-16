<?php

namespace WebVerantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FaqType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pregunta','text',array(
                'max_length' => 50,
                'required' => false,
                'attr' => array('class' => 'form-control')
                ))
                
            ->add('respuesta','textarea', array(
                'max_length' => 500,
                'required' => false,
                'attr' => array('class' => 'summernote form-control')
                ))
                
            ->add('isActive', 'checkbox', array(
                'attr' => array('class' => 'checkbox'),
                'label' => 'Activo',
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'WebVerantBundle\Entity\Faq'
        ));
    }
}

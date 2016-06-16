<?php

namespace WebVerantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class ProcesoType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('titulo', 'text', array(
                    'max_length' => 50,
                'label' => 'Título',
                    'attr' => array('class' => 'form-control')
                ))
                ->add('texto', 'textarea', array(
                    'max_length' => 500,
                    'required' => false,
                    'attr' => array('class' => 'summernote form-control')
                ))
                ->add('despliegue', 'choice', array(
                    'choices' => array(
                        'SERV_PERS' => 'Servicios Personas',
                        'SERV_EMP' => 'Servicios Empresas'),
                    'placeholder' => '-- Seleccione donde se despliega la información --',
                    'empty_data' => null,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('posicion', 'hidden', array(
                    'data' => 'PROCESO'
                ))
                ->add('orden', 'integer', array(
                    'attr' => array('class' => 'form-control')
                ))
                ->add('isActive', 'checkbox', array(
                    'label' => 'Activo',
                    'required' => false
                ))
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

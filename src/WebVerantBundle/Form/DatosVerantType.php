<?php

namespace WebVerantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatosVerantType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('nombre', 'text', array(
                    'max_length' => 50,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('rut', 'text', array(
                    'max_length' => 50,
                    'attr' => array('class' => 'form-control')
                ))

//            ->add('dv','choice', array(
//                'choices' => array(
//                    '0' => '0',
//                    '1' => '1',
//                    '2' => '2',
//                    '3' => '3', 
//                    '4' => '4', 
//                    '5' => '5', 
//                    '6' => '6',
//                    '7' => '7',
//                    '8' => '8',
//                    '9' => '9',
//                    'k' => 'k'),
//                'placeholder' => 'Seleccione',
//                'empty_data' => null,
//                'attr' => array('class' => 'form-control')
//                ))
                ->add('direccion', 'text', array(
                    'max_length' => 255,
                'label' => 'Dirección',
                    'attr' => array('class' => 'form-control')
                ))
                ->add('numero', 'integer', array(
                    'scale' => 0,
                'label' => 'Número',
                    'attr' => array('class' => 'form-control')
                ))
                ->add('departamento', 'text', array(
                    'max_length' => 50,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('codigoPais', 'choice', array(
                    'choices' => array(
                        '(+56)' => '(+56) chile',
                        '(+51)' => '(+51) Perú',
                        '(+54)' => '(+54) Argentina',
                        '(+55)' => '(+55) Brasil',
                        '(+57)' => '(+57) Colombia',
                        '(+58)' => '(+58) Venezuela',
                        '(+591)' => '(+591) Bolivia',
                        '(+592)' => '(+592) Guyana',
                        '(+593)' => '(+593) Ecuador',
                        '(+594)' => '(+594) Guayana Francesa',
                        '(+595)' => '(+595) Paraguay',
                        '(+597)' => '(+597) Surinam',
                        '(+598)' => '(+598) Uruguay',
                        '(+500)' => '(+500) Islas Malvidas'
                    ),
                    'placeholder' => 'Seleccione',
                    'empty_data' => null,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('telefono1', 'integer', array(
                    'scale' => 0,
                'label' => 'Teléfono 1',
                    'attr' => array('class' => 'form-control')
                ))
                ->add('telefono2', 'integer', array(
                    'scale' => 0,
                'label' => 'Teléfono 2',
                    'attr' => array('class' => 'form-control')
                ))
                ->add('email', 'email', array(
                    'max_length' => 50,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('terminos','file', array(
                    'required' => false,
                    'data_class'=> null,
                    'attr' => array('class' => 'custom-file-upload', 'id' => 'terminos', 'data-btn-text' => "Seleccione un Archivo")
                    ))
                ->add('googleMap', 'text', array(
                    'max_length' => 255,
                    'required' => false,
                'label' => 'Google Maps',
                    'attr' => array('class' => 'form-control')
                ))
                ->add('facebook', 'text', array(
                    'max_length' => 255,
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('twiter', 'text', array(
                    'max_length' => 255,
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('linkedin', 'text', array(
                    'max_length' => 255,
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('googlePlus', 'text', array(
                    'max_length' => 255,
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('rss', 'text', array(
                    'max_length' => 255,
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('mision', 'textarea', array(
                    'max_length' => 500,
                    'required' => false,
                'label' => 'Misión',
                    'attr' => array('class' => 'summernote form-control')
                ))
                ->add('vision', 'textarea', array(
                    'max_length' => 500,
                    'required' => false,
                'label' => 'Visión',
                    'attr' => array('class' => 'summernote form-control')
                ))
                ->add('descripcion', 'textarea', array(
                    'max_length' => 500,
                'label' => 'Descripción',
                    'required' => false,
                    'attr' => array('class' => 'summernote form-control')
                ))
                ->add('isActive', 'hidden', array(
                    'data' => true,
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
            'data_class' => 'WebVerantBundle\Entity\DatosVerant'
        ));
    }

}

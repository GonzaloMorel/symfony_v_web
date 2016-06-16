<?php

namespace WebVerantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;

class ContenidoType extends AbstractType
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
                'label' => 'Título',
                'attr' => array('class' => 'form-control')
                ))
                
            ->add('subtitulo','text',array(
                'max_length' => 50,
                'label' => 'Subtítulo',
                'required' => false,
                'attr' => array('class' => 'form-control')
                ))
                
            ->add('texto','textarea', array(
                'max_length' => 500,
                'required' => false,
                'attr' => array('class' => 'summernote form-control')
                ))
                
            ->add('imagen', 'file', array(
                'required' => false,
                'data_class'=> null,
                'attr' => array('class' => 'custom-file-upload', 'id' => 'file', 'data-btn-text' => "Seleccione un Archivo")
                ))
                
            ->add('urlVideo','url',array(
                'required' => false,
                'label' => 'URL Video',
                'attr' => array('class' => 'form-control')
            ))
                
            ->add('despliegue','choice', array(
                'choices' => array(
                    'HOME' => 'Home',
                    'SERV_PERS' => 'Servicios Personas',
                    'SERV_EMP' => 'Servicios Empresas',
                    'ABOUT' => 'Quienes Somos', 
                    'FAQ' => 'Preguntas Frecuentes', 
                    'CONTACT' => 'Contacto', 
                    'TERMINOS' => 'Contrato Términos'),
                'placeholder' => '-- Seleccione donde se despliega la información --',
                'empty_data' => null,
                'attr' => array('class' => 'form-control')
                ))
                
            ->add('posicion','choice', array(
                'choices' => array(
                    'PRIMARIO' => 'Contenido Primario',
                    'SECUNDARIO' => 'Contenido Secundario'),
                'placeholder' => '-- Seleccione donde se muestra la información --',
                'empty_data' => null,
                'label' => 'Posición',
                'attr' => array('class' => 'form-control')
                ))
             
            ->add('isActive', 'checkbox', array(
                'attr' => array('class' => 'checkbox'),
                'label' => 'Activo',
            ));

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

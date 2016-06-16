<?php

namespace WebVerantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HorarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dias','choice', array(
                'choices' => array(
                    'Lunes - Viernes' => 'Lunes - Viernes',
                    'Sábado' => 'Sábado',
                    'Domingo' => 'Domingo'),
                'placeholder' => '-- Seleccione el rango --',
                'empty_data' => null,
                'label' => 'Días',
                'attr' => array('class' => 'form-control')
                ))
                
            ->add('horaDesde', 'time', array(
                'input' => 'datetime',
                'widget' => 'choice',
                'label' => 'Hora Inicio',
                'placeholder' => 'Seleccione',
                'attr' => array(
                    'class' => ''
                )
            ))
                
            ->add('horaHasta', 'time', array(
                'input' => 'datetime',
                'widget' => 'choice',
                'label' => 'Hora Término',
                'placeholder' => 'Seleccione',
                'attr' => array(
                    'class' => ''
                )
            ))
                
            ->add('isActive','checkbox', array(
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
            'data_class' => 'WebVerantBundle\Entity\Horario'
        ));
    }
}

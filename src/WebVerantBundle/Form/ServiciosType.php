<?php

namespace WebVerantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiciosType extends AbstractType
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
                'attr' => array('class' => 'form-control'),
                'required' => false
                ))
                
            ->add('despliegue','choice', array(
                'choices' => array(
                    'SERV_PERS' => 'Servicios Personas',
                    'SERV_EMP' => 'Servicios Empresas'),
                'placeholder' => '-- Seleccione donde se despliega la información --',
                'empty_data' => null,
                'attr' => array('class' => 'form-control')
                ))
                
            ->add('posicion','hidden', array(
                'data' => 'SERVICIO'
            ))
                
            ->add('icono', 'choice' , array(
                'choices' => array(
                    'et-adjustments' => 'et-adjustments',  
                    'et-alarmclock' => 'et-alarmclock',
                    'et-anchor' => 'et-anchor',
                    'et-aperture' => 'et-aperture',
                    'et-attachment' => 'et-attachment',
                    'et-bargraph' => 'et-bargraph',
                    'et-basket' => 'et-basket',
                    'et-beaker' => 'et-beaker',
                    'et-bike' => 'et-bike',
                    'et-book-open' => 'et-book-open',
                    'et-briefcase' => 'et-briefcase',
                    'et-browser' => 'et-browser',
                    'et-calendar' => 'et-calendar',
                    'et-camera' => 'et-camera',
                    'et-caution'=> 'et-caution',
                    'et-chat' => 'et-chat',
                    'et-circle-compass' => 'et-circle-compass',
                    'et-clipboard' => 'et-clipboard',
                    'et-clock' => 'et-clock',
                    'et-cloud' => 'et-cloud',
                    'et-compass' => 'et-compass',
                    'et-desktop' => 'et-desktop',
                    'et-dial' => 'et-dial',
                    'et-document' => 'et-document',
                    'et-documents' => 'et-documents',
                    'et-download' => 'et-download',
                    'et-dribbble' => 'et-dribbble',
                    'et-edit' => 'et-edit',
                    'et-envelope' => 'et-envelope',
                    'et-expand' => 'et-expand',
                    'et-facebook' => 'et-facebook',
                    'et-flag' => 'et-flag',
                    'et-focus' => 'et-focus',
                    'et-gears' => 'et-gears',
                    'et-genius' => 'et-genius',
                    'et-gift' => 'et-gift',
                    'et-global' => 'et-global',
                    'et-globe' => 'et-globe',
                    'et-googleplus' => 'et-googleplus',
                    'et-grid' => 'et-grid',
                    'et-happy' => 'et-happy',
                    'et-hazardous' => 'et-hazardous',
                    'et-heart' => 'et-heart',
                    'et-hotairballoon' => 'et-hotairballoon',
                    'et-hourglass' => 'et-hourglass',
                    'et-key' => 'et-key',
                    'et-laptop' => 'et-laptop',
                    'et-layers' => 'et-layers',
                    'et-lifesaver' => 'et-lifesaver',
                    'et-lightbulb' => 'et-lightbulb',
                    'et-linegraph' => 'et-linegraph',
                    'et-linkedin' => 'et-linkedin',
                    'et-lock' => 'et-lock',
                    'et-magnifying-glass' => 'et-magnifying-glass',
                    'et-map' => 'et-map',
                    'et-map-pin' => 'et-map-pin',
                    'et-megaphone'=> 'et-megaphone',
                    'et-mic' => 'et-mic',
                    'et-mobile' => 'et-mobile',
                    'et-newspaper' => 'et-newspaper',
                    'et-notebook' => 'et-notebook',
                    'et-paintbrush' => 'et-paintbrush',
                    'et-paperclip' => 'et-paperclip',
                    'et-pencil' => 'et-pencil',
                    'et-phone' => 'et-phone',
                    'et-picture' => 'et-picture',
                    'et-pictures' => 'et-pictures',
                    'et-piechart' => 'et-piechart',
                    'et-presentation' => 'et-presentation',
                    'et-pricetags' => 'et-pricetags',
                    'et-printer'=> 'et-printer',
                    'et-profile-female' => 'et-profile-female',
                    'et-profile-male' => 'et-profile-male',
                    'et-puzzle' => 'et-puzzle',
                    'et-quote' => 'et-quote',
                    'et-recycle' => 'et-recycle',
                    'et-refresh' => 'et-refresh',
                    'et-ribbon' => 'et-ribbon',
                    'et-rss' => 'et-rss',
                    'et-sad' => 'et-sad',
                    'et-scissors' => 'et-scissors',
                    'et-scope' => 'et-scope',
                    'et-search' => 'et-search',
                    'et-shield' => 'et-shield',
                    'et-speedometer' => 'et-speedometer',
                    'et-strategy' => 'et-strategy',
                    'et-streetsign' => 'et-streetsign',
                    'et-tablet' => 'et-tablet',
                    'et-target' => 'et-target',
                    'et-telescope' => 'et-telescope',
                    'et-toolbox' => 'et-toolbox',
                    'et-tools' => 'et-tools',
                    'et-tools-2' => 'et-tools-2',
                    'et-trophy' => 'et-trophy',
                    'et-tumblr' => 'et-tumblr',
                    'et-twitter' => 'et-twitter',
                    'et-upload' => 'et-upload',
                    'et-video' => 'et-video',
                    'et-wallet' => 'et-wallet',
                    'et-wine' => 'et-wine'
                ),
                'empty_value' => '-- Seleccione el icono, solo  --',
                'empty_data' => null,
                'attr' => array('class'=>'selectpicker form-control select'),
                'choices_as_values' => true,
                'choice_attr' => function($val, $key, $index){
                    return ['data-icon' => $val];
                }
            ))
            
            ->add('orden', 'integer', array(
                    'attr' => array('class' => 'form-control')
                ))
                
            ->add('isActive', 'checkbox', array(
                'required' => false,
                'label' => 'Activo'
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

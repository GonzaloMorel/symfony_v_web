<?php

namespace VerantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class UsuarioEmpresaType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('rut', 'text', array(
                    'max_length' => 10,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('nombres', 'text', array(
                    'max_length' => 50,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('apPat', 'text', array(
                    'max_length' => 50,
                    'label' => 'Apellido Paterno',
                    'attr' => array('class' => 'form-control')
                ))
                ->add('apMat', 'text', array(
                    'max_length' => 50,
                    'label' => 'Apellido Materno',
                    'attr' => array('class' => 'form-control')
                ))
                ->add('cargo', 'text', array(
                    'max_length' => 50,
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
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
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))

//                ->add('region', 'choice', array(
//                    'choices' => array(
//                        "357" => 'Metropolitana de Santiago',
//                        "2" => 'Arica-Parinacota',
//                        "9" =>'Iquique',
//                        "19"=>'Antofagasta',
//                        "32"=>'Atacama',
//                        "45"=>'Coquimbo',
//                        "64"=>'Valparaíso',
//                        "110"=>'Libertador General Bernardo OHiggins',
//                        "147"=>'Maule',
//                        "182"=>'Bío - Bío',
//                        "241"=>'Araucanía',
//                        "276"=>'Los Ríos',
//                        "291"=>'Los Lagos',
//                        "326"=>'Aysén del General Carlos Ibáñez del Campo',
//                        "341"=>'Magallanes y la Antártica Chilena'
//                    ),
//                    'placeholder' => 'Región',
//                    'empty_data' => null,
//                    'attr' => array('class' => 'form-control')
//                ))
//                ->add('ciudad', 'choice', array(
//                    'placeholder' => 'Ciudad',
//                    'empty_data' => null,
//                    'attr' => array('class' => 'form-control')
//                ))
//                ->add('comuna', 'choice', array(
//                    'placeholder' => 'Comuna',
//                    'empty_data' => null,
//                    'attr' => array('class' => 'form-control')
//                ))
                ->add('region', 'entity', array(
                    'class' => 'VerantBundle:Provincias',
                    'placeholder' => 'Regiones',
                    'query_builder' => function(EntityRepository $er){
                            return $er->createQueryBuilder('r')
                                    ->where('r.padrePrv = 1')
                                    ->orderBy('r.ordenPrv', 'ASC');
                    },
                    'choice_label' => 'nombrePrv',
                    'attr' => array('class' => 'form-control')
                ))
                ->add('ciudad', 'entity', array(
                    'class' => 'VerantBundle:Provincias',
                    'placeholder' =>'Ciudades',
                    'choice_label' => 'nombrePrv',
                    'attr' => array('class' => 'form-control')
                ))
                ->add('comuna', 'entity', array(
                    'class' => 'VerantBundle:Provincias',
                    'placeholder' => 'comunas',
                    'choice_label' => 'nombrePrv',
                    'attr' => array('class' => 'form-control')
                ))
                
                ->add('email', 'email', array(
                    'max_length' => 255,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('roles', 'hidden', array(
                    'data' => 'ROLE_USER'
                ))
                ->add('tipo', 'hidden', array(
                    'data' => 'USU_EMP'
                ))
                ->add('cargo', 'text', array(
                    'max_length' => 50,
                    'required' => false,
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
                ->add('telefono', 'integer', array(
                    'scale' => 0,
                    'label' => 'Teléfono',
                    'attr' => array('class' => 'form-control')
                ))
                ->add('password', 'password', array(
                    'max_length' => 50,
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                ))
                ->add('isActive', 'checkbox', array(
                    'required' => false,
                    'label' => 'Activo',
                    'attr' => array('class' => 'checkbox')
                ))

        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VerantBundle\Entity\Usuario'
        ));
    }

}

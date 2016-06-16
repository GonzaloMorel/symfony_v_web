<?php

namespace VerantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use VerantBundle\Entity\Usuario;
use VerantBundle\Form\UsuarioEmpresaType;

/**
 * Usuario controller.
 *
 */
class UsuarioEmpresaController extends Controller {

    /**
     * Lists all Usuario entities.
     *
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession(); //obtengo la session
        if ($session->get('login') == true)://verifico si el usuario esta logueado
            $em = $this->getDoctrine()->getManager();

            $dql = "SELECT u FROM VerantBundle:Usuario u WHERE u.tipo = 'USU_EMP'";

            $user = $em->createQuery($dql);

            $paginador = $this->get('knp_paginator');
            $paginacion = $paginador->paginate(
                    $user, $request->query->getInt('page', 1), 10
            );
            return $this->render('usuarioempresa/index.html.twig', array(
                        'pagination' => $paginacion
            ));
        else://si no está logueado lo reenvío a loguearse
            $this->get('session')->getFlashBag()->add("mensaje", "Debe Loguearse"); //mensaje para loguearse
            return $this->redirectToRoute('web_verant_login'); //redireccion
        endif;
    }

    /**
     * Creates a new Usuario entity.
     *
     */
    public function newAction(Request $request)
    {
        set_time_limit(300);
        $session = $request->getSession(); //obtengo la session
        if ($session->get('login') == true)://verifico si el usuario esta logueado
            $usuario = new Usuario();


            $form = $this->createForm('VerantBundle\Form\UsuarioEmpresaType', $usuario);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                //formateo de rut
                $rutF = $this->formatoRut($form->get('rut')->getData()); //tomo el rut y lo envío a la funcion formatoRut, la cual me devuelve el rut sin puntos y separado del dv
                $rut = $rutF['rut'];
                $dv = $rutF['dv'];

                //Encriptacion de password
                $password = md5($form->get('password')->getData()); //obtengo el dato
                //
                $region = $form->get('region')->getData();
                $ciudad = $form->get('ciudad')->getData();
                $comuna = $form->get('comuna')->getData();
                
                
                $usuario->setRegion($region);
                $usuario->setCiudad($ciudad);
                $usuario->setComuna($comuna);
                //
                //setteo de variables
                $usuario->setPassword($password); //setteo el password
                $usuario->setRut($rut);
                $usuario->setDv($dv);

                
                $em = $this->getDoctrine()->getManager();
                $em->persist($usuario);
                $em->flush();

                return $this->redirectToRoute('usuario_empresa_index', array('id' => $usuario->getId()));
            }

            return $this->render('usuarioempresa/new.html.twig', array(
                        'usuario' => $usuario,
                        'form' => $form->createView(),
            ));
        else://si no está logueado lo reenvío a loguearse
            $this->get('session')->getFlashBag()->add("mensaje", "Debe Loguearse"); //mensaje para loguearse
            return $this->redirectToRoute('web_verant_login'); //redireccion
        endif;
    }

    /**
     * Finds and displays a Usuario entity.
     *
     */
    public function showAction(Usuario $usuario, Request $request)
    {
        $session = $request->getSession(); //obtengo la session
        if ($session->get('login') == true)://verifico si el usuario esta logueado
            $deleteForm = $this->createDeleteForm($usuario);

//            print_r($usuario);
//            exit();

            return $this->render('usuarioempresa/show.html.twig', array(
                        'usuario' => $usuario,
                        'delete_form' => $deleteForm->createView(),
            ));
        else://si no está logueado lo reenvío a loguearse
            $this->get('session')->getFlashBag()->add("mensaje", "Debe Loguearse"); //mensaje para loguearse
            return $this->redirectToRoute('web_verant_login'); //redireccion
        endif;
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     */
    public function editAction(Request $request, Usuario $usuario)
    {
        set_time_limit(300);
        $session = $request->getSession(); //obtengo la session

        if ($session->get('login') == true)://verifico si el usuario esta logueado

            $deleteForm = $this->createDeleteForm($usuario); // creo el formulario para la eliminacion del registro

            $dv = $usuario->getDv(); //obtengo el Dv desde el formulario creado
            $rut = $this->puntosRut($usuario->getRut()); //setteo el rut para agregar los puntos

            $usuario->setRut($rut . '-' . $dv); // envío el rut setteado al formulario


            $editForm = $this->createForm('VerantBundle\Form\UsuarioEmpresaType', $usuario); // creo el formulario
//            $editForm->setRut($rut . '-' . $dv);
            $editForm->handleRequest($request); // obtengo el formulario

            if ($editForm->isSubmitted() && $editForm->isValid()) { //solo si se envía un formulario

                $pass = $editForm->get('password')->getData(); //obtengo el password del usuario desde el formulario

                
                $region = $editForm->get('region')->getData();
                $ciudad = $editForm->get('ciudad')->getData();
                $comuna = $editForm->get('comuna')->getData();
                
                
                $usuario->setRegion($region);
                $usuario->setCiudad($ciudad);
                $usuario->setComuna($comuna);
                
                if (!empty($pass)) {//si existe un password lo setteo
                    //Encriptacion de password
                    $password = md5($editForm->get('password')->getData()); //obtengo el dato

                    $usuario->setPassword($password); //setteo el password
                } else {
                    //si no existe un password lo recupero de la BD
                    $recoverPass = $this->recoverPass($usuario->getId());
                    $usuario->setPassword($recoverPass[0]['password']);
                }


                $rutF = $this->formatoRut($editForm->get('rut')->getData()); //tomo el rut y lo envío a la funcion formatoRut, la cual me devuelve el rut sin puntos y separado del dv
                $rut = $rutF['rut']; //obtengo el rut
                $dv = $rutF['dv']; //obtengo el dv
                $usuario->setRut($rut); //envío el rut
                $usuario->setDv($dv); // envio el dv


                $em = $this->getDoctrine()->getManager();
                $em->persist($usuario);
                $em->flush();

                $this->get('session')->getFlashBag()->add("mensaje", "Usuario Actualizado"); //mensaje para loguearse
                return $this->redirectToRoute('usuario_empresa_index', array('id' => $usuario->getId()));
            }

            return $this->render('usuarioempresa/edit.html.twig', array(
                        'usuario' => $usuario,
                        'edit_form' => $editForm->createView(),
                        'delete_form' => $deleteForm->createView(),
            ));
        else://si no está logueado lo reenvío a loguearse
            $this->get('session')->getFlashBag()->add("mensaje", "Debe Loguearse"); //mensaje para loguearse
            return $this->redirectToRoute('web_verant_login'); //redireccion
        endif;
    }

    /**
     * Deletes a Usuario entity.
     *
     */
    public function deleteAction(Request $request, Usuario $usuario)
    {
        $session = $request->getSession(); //obtengo la session
        if ($session->get('login') == true)://verifico si el usuario esta logueado
            $form = $this->createDeleteForm($usuario);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($usuario);
                $em->flush();
            }

            return $this->redirectToRoute('usuario_empresa_index');

        else://si no está logueado lo reenvío a loguearse
            $this->get('session')->getFlashBag()->add("mensaje", "Debe Loguearse"); //mensaje para loguearse
            return $this->redirectToRoute('web_verant_login'); //redireccion
        endif;
    }

    /**
     * Creates a form to delete a Usuario entity.
     *
     * @param Usuario $usuario The Usuario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usuario $usuario)
    {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('usuario_delete', array('id' => $usuario->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    

    public function registroAction(Request $request)
    {
        if ($request->getMethod() == "POST") {
            
//            $data = $this->getRequest()->request->get('registro'); // obtengo todos los objetos request del formulario
            $file = $this->getRequest()->files->get('registro'); // obtengo el archivo del formulario

            $registro = $request->get('registro');
//            print_r($registro);
//            print_r($file['archivo']);
//            print_r($_FILES);
//            exit();

            $rutF = $this->formatoRut($registro['rut']);
            $rut = $rutF['rut'];
            $dv = $rutF['dv'];
            $nombres = $registro['nombres'];
            $apPat = $registro['ap_pat'];
            $apMat = $registro['ap_mat'];
            $email = $registro['email'];
            $telefono = $registro['telefono'];
            $calle = $registro['calle'];
            $numero = $registro['numero'];
            $depa = $registro['depa'];
            $comuna = $registro['comuna'];
            $pass1 = $registro['pass1'];
            $pass2 = $registro['pass2'];
            $terminos = $registro['terminos'];
//            $file = $file['archivo'];



            $usuario = new Usuario();
            $em = $this->getDoctrine()->getManager();
            $res = $em->getRepository('VerantBundle:Usuario')->findOneBy(array('rut' => $rut));

            if ($res) {

                $this->get('session')->getFlashBag()->add("mensaje", "Usuario ya existe!!");
                return $this->redirect($this->generateUrl('usuario_index'));
            } else {

                if ($pass1 == $pass2) {

                    //Encriptacion de password
                    $password = md5($pass1); //obtengo el dato



                    if ($file['archivo'] && $file['archivo']->getError() == 0) {
                        
                        $archivo = $this->fileToBase64($file['archivo']);
                        
                        $arch = $archivo['base64'];
                        $tip = $archivo['tipo'];
                        $tipo = explode('/', $archivo['tipo']);

                        $validos = array('pdf', 'jpg', 'jpeg', 'png');

                        if (!in_array(strtolower($tipo[1]), $validos)) {

                            $this->get('session')->getFlashBag()->add("mensaje", "El Archivo que intentó subir no está permitido");
                            return $this->redirectToRoute('web_verant_login');
                        } else {

                            if ($file['archivo']->getSize() >= 10485760) {

                                $contacto->setArchivo($arch);
                                $contacto->setArchivoTipo($tip);
                            } else {
                                $this->get('session')->getFlashBag()->add("mensaje", "El Archivo es demasiado pesado");
                                return $this->redirectToRoute('web_verant_login');
                            }
                        }
                    } else {
                        $this->get('session')->getFlashBag()->add("mensaje", "Existió un error con el archivo, favor reintente");
                        return $this->redirectToRoute('web_verant_login');
                    }

                    $usuario->setNombres($nombres);
                    $usuario->setRut($rut);
                    $usuario->setDv($dv);
                    $usuario->setApPat($apPat);
                    $usuario->setApMat($apMat);
                    $usuario->setEmail($email);
                    $usuario->setTelefono($telefono);
                    $usuario->setDireccion($calle);
                    $usuario->setNumero($numero);
                    $usuario->setDepartamento($depa);
                    $usuario->setImagenUsu('');
                    $usuario->setImagenUsuTipo('');
                    $usuario->setPublico(false);
                    //$usuario->setComuna($comuna);
                    $usuario->setPassword($encoded); //setteo el password
                    $usuario->setConcentimiento($terminos);
                    $usuario->setRoles('ROLE_USER');
                    $usuario->setTipo('USU_NAT');
                    $usuario->setIsActive(false);


                    $em->persist($usuario);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add("mensaje", "Sus Datos Han Sido Enviados, Debe Esperar Confirmación");

                    return $this->redirect($this->generateUrl('web_verant_login'));
                } else {
                    $this->get('session')->getFlashBag()->add("mensaje", "Password Invalido");
                    return $this->redirect($this->generateUrl('web_verant_login'));
                }
            }
        }
    }

    private function formatoRut($rut)
    {
        $rut = explode('-', $rut);
        $dv = $rut[1];
        $rut = str_replace('.', '', $rut[0]);

        return array('rut' => $rut, 'dv' => $dv);
    }

    private function puntosRut($rut)
    {

//        echo $rut;
//        exit();
        $u3 = substr($rut, strlen($rut) - 3, strlen($rut));
        $s3 = substr($rut, strlen($rut) - 6, strlen($rut) - 5);
        $p3 = substr($rut, 0, strlen($rut) - 6);
        return $p3 . "." . $s3 . "." . $u3;
    }

    private function recoverPass($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "Select u.password from VerantBundle:Usuario u Where u.id = :id")->setParameter('id', $id);

        $currentPass = $query->getResult();

        return $currentPass;
    }

    private function recoverImage($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "Select u.imagenUsu, u.imagenUsuTipo from VerantBundle:Usuario u Where u.id = :id")->setParameter('id', $id);

        $currentImage = $query->getResult();

        return $currentImage;
    }

    private function recoverImageCi($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "Select u.imagenCi, u.imagenCiTtipo from VerantBundle:Usuario u Where u.id = :id")->setParameter('id', $id);

        $currentPass = $query->getResult();

//        print_r($currentPass);
//        exit();

        return $currentPass;
    }

}

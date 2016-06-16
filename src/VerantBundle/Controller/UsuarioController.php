<?php

namespace VerantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use VerantBundle\Entity\Usuario;
use VerantBundle\Entity\Provincias;
use VerantBundle\Form\UsuarioType;

/**
 * Usuario controller.
 *
 */
class UsuarioController extends Controller {

    /**
     * Lists all Usuario entities.
     *
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession(); //obtengo la session
        if ($session->get('login') == true)://verifico si el usuario esta logueado
            $em = $this->getDoctrine()->getManager();

            $dql = "SELECT u FROM VerantBundle:Usuario u WHERE u.tipo = 'USU_VERANT'";

            $user = $em->createQuery($dql);

            $paginador = $this->get('knp_paginator');
            $paginacion = $paginador->paginate(
                    $user, $request->query->getInt('page', 1), 10
            );
            return $this->render('usuario/index.html.twig', array(
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


            $form = $this->createForm('VerantBundle\Form\UsuarioType', $usuario);            
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $imagenUsu = $form->get('imagenUsu')->getData(); //rescato la imagen del usuario
                //
                //formateo de rut
                $rutF = $this->formatoRut($form->get('rut')->getData()); //tomo el rut y lo envío a la funcion formatoRut, la cual me devuelve el rut sin puntos y separado del dv
                $rut = $rutF['rut'];
                $dv = $rutF['dv'];
                
                $region = $form->get('region')->getData();
                $ciudad = $form->get('ciudad')->getData();
                $comuna = $form->get('comuna')->getData();
                
                
                $usuario->setRegion($region);
                $usuario->setCiudad($ciudad);
                $usuario->setComuna($comuna);

                //Encriptacion de password
                $password = md5($form->get('password')->getData()); //obtengo el dato
                //setteo de variables
                $usuario->setPassword($password); //setteo el password
                $usuario->setRut($rut);
                $usuario->setDv($dv);

                //si hay un archivo de imagen la tomo y la transformo en base64
                if (($imagenUsu instanceof UploadedFile) && $imagenUsu->getError() == 0) {

                    $tipo = $imagenUsu->getMimeType();
                    $file = file_get_contents($imagenUsu->getPathname());
                    $base64 = base64_encode($file);
                    $usuario->setImagenUsuTipo($tipo);
                    $usuario->setImagenUsu($base64);
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($usuario);
                $em->flush();

                return $this->redirectToRoute('usuario_index', array('id' => $usuario->getId()));
            }

            return $this->render('usuario/new.html.twig', array(
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
        set_time_limit(300);
        $session = $request->getSession(); //obtengo la session
        if ($session->get('login') == true)://verifico si el usuario esta logueado
            $deleteForm = $this->createDeleteForm($usuario);
                        
            $em = $this->getDoctrine()->getManager();

//            $comuna = $em->getRepository('VerantBundle:Provincias')->findByIdPrv($usuario->getComuna());

            return $this->render('usuario/show.html.twig', array(
                        'usuario' => $usuario,
//                        'comuna' => $comuna,
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
//        print_r($_POST);
//        exit();
        $session = $request->getSession(); //obtengo la session

        if ($session->get('login') == true)://verifico si el usuario esta logueado

            $deleteForm = $this->createDeleteForm($usuario); // creo el formulario para la eliminacion del registro

            $dv = $usuario->getDv(); //obtengo el Dv desde el formulario creado
            $rut = $this->puntosRut($usuario->getRut()); //setteo el rut para agregar los puntos

            $usuario->setRut($rut . '-' . $dv); // envío el rut setteado al formulario
            

            $editForm = $this->createForm('VerantBundle\Form\UsuarioType', $usuario); // creo el formulario
//            $editForm->setRut($rut . '-' . $dv);
            $editForm->handleRequest($request); // obtengo el formulario
            
            if ($editForm->isSubmitted() && $editForm->isValid()) { //solo si se envía un formulario
           
                
                $imagenUsu = $editForm->get('imagenUsu')->getData(); //obtengo la imagen del usuario //desde el formulario

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

                if (($imagenUsu instanceof UploadedFile) && $imagenUsu->getError() == 0) {

                    $tipo = $imagenUsu->getMimeType();
                    $file = file_get_contents($imagenUsu->getPathname());
                    $base64 = base64_encode($file);
                    $usuario->setImagenUsuTipo($tipo);
                    $usuario->setImagenUsu($base64);
                } else {
                    $imagenRecover = $this->recoverImage($usuario->getId());

                    $imagenI = stream_get_contents($imagenRecover[0]['imagenUsu']);
                    $tipoI = $imagenRecover[0]['imagenUsuTipo'];

                    $usuario->setImagenUsuTipo($tipoI);
                    $usuario->setImagenUsu($imagenI);
                }


                $em = $this->getDoctrine()->getManager();
                $em->persist($usuario);
                $em->flush();

                $this->get('session')->getFlashBag()->add("mensaje", "Usuario Actualizado"); //mensaje para loguearse
                return $this->redirectToRoute('usuario_index', array('id' => $usuario->getId()));
            }

            return $this->render('usuario/edit.html.twig', array(
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

            return $this->redirectToRoute('usuario_index');

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

    /**
     * Metodo para loggin
     * @param Request $request
     * @return type
     */
    public function loginAction(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $login = $request->get('login');

            $rut = $login['rut'];

            $rut = explode('-', $rut);
            $dv = $rut[1];
            $rut = str_replace('.', '', $rut[0]);

            $pass = $login['password'];

            $em = $this->getDoctrine()->getManager();

            $res = $em->getRepository('VerantBundle:Usuario')->findOneBy(array('rut' => $rut, 'password' => $pass));

            if ($res) {
                $session = $request->getSession();
                $session->set("id", $res->getId());
                $session->set("nombres", $res->getNombres());
                $session->set("apPat", $res->getApPat());
                $session->set("apMat", $res->getApMat());
                $session->set("rut", $res->getRut() . "-" . $res->getDv());
                $session->set("email", $res->getEmail());
                $session->set("login", true);

                return $this->redirect($this->generateUrl('web_verant_login'));
            } else {
                $this->get('session')->getFlashBag()->add("mensaje", "Los Datos No Son Válidos");
                return $this->redirect($this->generateUrl('usuario_index'));
            }
        }

        return $this->render('usuario/index.html.twig');
    }

    /**
     * Metodo para deslogueo
     * @param Request $request
     * @return type
     */
    public function logout(Request $request)
    {
        $session = $request->getSession();
        $session->clear();

        $this->get('session')->getFlashBag()->add("mensaje", "Se ha cerrado la session");
        return $this->redirect($this->generateUrl('usuario_index'));
    }

    public function registroAction(Request $request)
    {
        set_time_limit(300);
        if ($request->getMethod() == "POST") {

//            $data = $this->getRequest()->request->get('registro'); // obtengo todos los objetos request del formulario
            $file = $this->getRequest()->files->get('registro'); // obtengo el archivo del formulario

            $registro = $request->get('registro');

            $rutF = $this->formatoRut($registro['rut']);
            $rut = $rutF['rut'];
            $dv = $rutF['dv'];
            
            $nombres = $registro['nombres'];
            $apPat = $registro['ap_pat'];
            $apMat = $registro['ap_mat'];
            $email = $registro['email'];
            if ($registro['telefono']) {
                $telefono = $registro['telefono'];
            } else {
                $telefono = 1;
            }
            $calle = $registro['calle'];
            $numero = $registro['numero'];
            $depa = $registro['depa'];
            $pass1 = $registro['pass1'];
            $pass2 = $registro['pass2'];
//            $terminos = $registro['terminos'];
//            $file = $file['archivo'];
            $region = $this->setterProvincias($registro['region']);
            $ciudad = $this->setterProvincias($registro['ciudad']);
            $comuna = $this->setterProvincias($registro['comuna']);


            $usuario = new Usuario();
            $provincia = new Provincias();
            
            
                   
            
            $em = $this->getDoctrine()->getManager();
            $res = $em->getRepository('VerantBundle:Usuario')->findOneBy(array('email' => $email)); //se cambia rut por email
//            $res = null;

            if ($res) {

                $this->get('session')->getFlashBag()->add("mensaje", "Usuario ya existe!!");
                return $this->redirect($this->generateUrl('web_verant_login'));
                
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

                            $this->get('session')->getFlashBag()->add("mensaje", "El Archivo C.I. que intentó subir no está permitido");
                            return $this->redirectToRoute('web_verant_login');
                        } 
                        else {

                            if ($file['archivo']->getSize() <= 10485760) {

                                $usuario->setImagenCi($arch);
                                $usuario->setImagenCiTipo($tip);
                                
                            } 
                            else {
                                $this->get('session')->getFlashBag()->add("mensaje", "El Archivo C.I. es demasiado pesado");
                                return $this->redirectToRoute('web_verant_login');
                            }
                        }
                    } 
                    else {
                        $this->get('session')->getFlashBag()->add("mensaje", "Existió un error con el archivo C.I., favor reintente");
                        return $this->redirectToRoute('web_verant_login');
                    }
                    
                    
                    if ($file['terminos'] && $file['terminos']->getError() == 0) {

                        $archivo = $this->fileToBase64($file['terminos']);

                        $arch = $archivo['base64'];
                        $tip = $archivo['tipo'];
                        $tipo = explode('/', $archivo['tipo']);

                        $validos = array('pdf', 'jpg', 'jpeg', 'png');

                        if (!in_array(strtolower($tipo[1]), $validos)) {

                            $this->get('session')->getFlashBag()->add("mensaje", "El Archivo Términos que intentó subir no está permitido");
                            return $this->redirectToRoute('web_verant_login');
                        } 
                        else {

                            if ($file['terminos']->getSize() <= 10485760) {

                                $usuario->setTerminos($arch);
                                $usuario->setTerminosTipo($tip);
                                
                            } 
                            else {
                                $this->get('session')->getFlashBag()->add("mensaje", "El Archivo Términos es demasiado pesado");
                                return $this->redirectToRoute('web_verant_login');
                            }
                        }
                    } 
                    else {
                        $this->get('session')->getFlashBag()->add("mensaje", "Existió un error con el archivo Términos, favor reintente");
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
                    
                    $usuario->setComuna($comuna);
                    $usuario->setCiudad($ciudad);
                    $usuario->setRegion($region);
                    
                    $usuario->setPassword($password); //setteo el password
                    
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

    private function fileToBase64($file)
    {

        $tipo = $file->getMimeType();
        $originalName = $file->getClientOriginalName();
        $path = file_get_contents($file->getPathname());
        $base64 = base64_encode($path);
        return array('tipo' => $tipo, 'base64' => $base64, 'originalName' => $originalName);
    }

    private function validaArchivo($file, $tipoA)
    {
//        print_r($file);
//        exit();
        if ($file && $file->getError() == 0) {

            $archivo = $this->fileToBase64($file);

            $arch = $archivo['base64'];
            $tip = $archivo['tipo'];
            $tipo = explode('/', $archivo['tipo']);

            $validos = array('pdf', 'jpg', 'jpeg', 'png');

            if (!in_array(strtolower($tipo[1]), $validos)) {

                $this->get('session')->getFlashBag()->add("mensaje", "El Archivo $tipoA que intentó subir no está permitido");
                return $this->redirectToRoute('web_verant_login');
            } else {

                if ($file->getSize() <= 10485760) {

                    return array('archivo' => $arch, 'tipo' => $tip);
                } else {
                    $this->get('session')->getFlashBag()->add("mensaje", "El Archivo $tipoA es demasiado pesado");
                    return $this->redirectToRoute('web_verant_login');
                }
            }
        } else {
            $this->get('session')->getFlashBag()->add("mensaje", "Existió un error con el archivo $tipoA, favor reintente");
            return $this->redirectToRoute('web_verant_login');
        }
    }
    
    
    private function setterProvincias($id){
        $em = $this->getDoctrine()->getManager();
        $res = $em->getRepository('VerantBundle:Provincias')->findOneBy(array('idPrv' => $id));
        
        return $res;
    }

}

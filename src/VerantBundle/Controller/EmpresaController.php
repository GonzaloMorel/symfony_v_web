<?php

namespace VerantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VerantBundle\Entity\Empresa;
use VerantBundle\Form\EmpresaType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Empresa controller.
 *
 */
class EmpresaController extends Controller {

    /**
     * Lists all Empresa entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT e FROM VerantBundle:Empresa e";

        $empresas = $em->createQuery($dql);

        $paginador = $this->get('knp_paginator');
        $paginacion = $paginador->paginate(
                $empresas, $request->query->getInt('page', 1), 10
        );

        return $this->render('empresa/index.html.twig', array(
                    'pagination' => $paginacion
        ));
    }

    /**
     * Creates a new Empresa entity.
     *
     */
    public function newAction(Request $request)
    {
        $empresa = new Empresa();
        $form = $this->createForm('VerantBundle\Form\EmpresaType', $empresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //formateo de rut
            $rutF = $this->formatoRut($form->get('rut')->getData()); //tomo el rut y lo envío a la funcion formatoRut, la cual me devuelve el rut sin puntos y separado del dv
            $rut = $rutF['rut'];
            $dv = $rutF['dv'];

            $empresa->setRut($rut);
            $empresa->setDv($dv);

            $region = $form->get('region')->getData();
            $ciudad = $form->get('ciudad')->getData();
            $comuna = $form->get('comuna')->getData();


            $empresa->setRegion($region);
            $empresa->setCiudad($ciudad);
            $empresa->setComuna($comuna);

            $em = $this->getDoctrine()->getManager();
            $em->persist($empresa);
            $em->flush();

            return $this->redirectToRoute('empresa_show', array('id' => $empresa->getId()));
        }

        return $this->render('empresa/new.html.twig', array(
                    'empresa' => $empresa,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Empresa entity.
     *
     */
    public function showAction(Empresa $empresa)
    {
        $deleteForm = $this->createDeleteForm($empresa);

        $em = $this->getDoctrine()->getManager();

        $comuna = $em->getRepository('VerantBundle:Provincias')->findByIdPrv($empresa->getComuna());

        if (!$comuna) {
            $comuna = array('nombrePrv' => 'Sin Comuna Asociada');
        }

        $ciudad = $em->getRepository('VerantBundle:Provincias')->findByIdPrv($empresa->getCiudad());

        if (!$ciudad) {
            $ciudad = array('nombrePrv' => 'Sin Ciudad Asociada');
        }

        $region = $em->getRepository('VerantBundle:Provincias')->findByIdPrv($empresa->getRegion());

        if (!$region) {
            $region = array('nombrePrv' => 'Sin Región Asociada');
        }


//        exit();
        return $this->render('empresa/show.html.twig', array(
                    'empresa' => $empresa,
                    'comuna' => $comuna,
                    'region' => $region,
                    'ciudad' => $ciudad,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Empresa entity.
     *
     */
    public function editAction(Request $request, Empresa $empresa)
    {
        $deleteForm = $this->createDeleteForm($empresa);

        $dv = $empresa->getDv();
        $rut = $this->puntosRut($empresa->getRut());
        $empresa->setRut($rut . '-' . $dv);


        $editForm = $this->createForm('VerantBundle\Form\EmpresaType', $empresa);
        $editForm->handleRequest($request);

//        print_r($editForm);
//            exit();

        if ($editForm->isSubmitted() && $editForm->isValid()) {



            //formateo de rut
            $rutF = $this->formatoRut($editForm->get('rut')->getData()); //tomo el rut y lo envío a la funcion formatoRut, la cual me devuelve el rut sin puntos y separado del dv
            $rut = $rutF['rut'];
            $dv = $rutF['dv'];
            $empresa->setRut($rut);
            $empresa->setDv($dv);

            $region = $editForm->get('region')->getData();
            $ciudad = $editForm->get('ciudad')->getData();
            $comuna = $editForm->get('comuna')->getData();


            $empresa->setRegion($region);
            $empresa->setCiudad($ciudad);
            $empresa->setComuna($comuna);


            $em = $this->getDoctrine()->getManager();
            $em->persist($empresa);
            $em->flush();

            return $this->redirectToRoute('empresa_index', array('id' => $empresa->getId()));
        }

        return $this->render('empresa/edit.html.twig', array(
                    'empresa' => $empresa,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Empresa entity.
     *
     */
    public function deleteAction(Request $request, Empresa $empresa)
    {
        $form = $this->createDeleteForm($empresa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($empresa);
            $em->flush();
        }

        return $this->redirectToRoute('empresa_index');
    }

    /**
     * Creates a form to delete a Empresa entity.
     *
     * @param Empresa $empresa The Empresa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Empresa $empresa)
    {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('empresa_delete', array('id' => $empresa->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
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
        $u3 = substr($rut, strlen($rut) - 3, strlen($rut));
        $s3 = substr($rut, strlen($rut) - 6, strlen($rut) - 5);
        $p3 = substr($rut, 0, strlen($rut) - 6);
        return $p3 . "." . $s3 . "." . $u3;
    }

    /**
     * 
     * @param Request $request
     * @return type
     */
    public function registroAction(Request $request)
    {
        set_time_limit(300);
        if ($request->getMethod() == "POST") {

            $registro = $request->get('registroE');


            $rutF = $this->formatoRut($registro['rut']);
            $rut = $rutF['rut'];
            $dv = $rutF['dv'];
            $nombre = $registro['nombres'];
            $email = $registro['email'];
            $telefono = $registro['telefono'];
            $contacto = $registro['contacto'];

            $empresa = new Empresa();

            $em = $this->getDoctrine()->getManager();
            $res = $em->getRepository('VerantBundle:Empresa')->findOneBy(array('rut' => $rut));


            if ($res) {

                $this->get('session')->getFlashBag()->add("mensaje", "Empresa ya existe!!");
                return $this->redirect($this->generateUrl('usuario_index'));
            } else {

                //setteo variables
                $empresa->setRut($rut);
                $empresa->setDv($dv);
                $empresa->setRazonSocial($nombre);
                $empresa->setTelefono($telefono);
                $empresa->setEmail($email);
                $empresa->setIsActive(true);

                $em->persist($empresa);
                $em->flush();

                $asunto = "Registro de Empresa: " . $nombre;

                $mensaje = "Estimado, se ha registrado una empresa, favor contactarse con $contacto al numero: $telefono y luego dirigirse al administrador/Empresa para completar la informacion";

                $this->sendMail($nombre, $email, $telefono, $asunto, $mensaje);

                $this->get('session')->getFlashBag()->add("mensaje", "Sus datos han sido enviados, un ejecutivo se contactará con usted a la brevedad");

                return $this->redirect($this->generateUrl('web_verant_login'));
            }
        }
    }

    /**
     * Este metodo se encarga de envíar el correo electrónico 
     * @param type $nombre
     * @param type $email
     * @param type $tel
     * @param type $asunto
     * @param type $mensaje
     */
    private function sendMail($nombre, $email, $tel, $asunto, $mensaje, $archivo = null)
    {
        $em = $this->getDoctrine()->getManager();

        $mailVerant = $em->getRepository('WebVerantBundle:DatosVerant')->find(1);

        $message = \Swift_Message::newInstance();
        $message->setSubject($asunto);
        $message->setFrom($email);
        $message->setTo($mailVerant->getEmail());
        if ($archivo) {

            $t = explode('/', $archivo['tipo']);
            $attach = \Swift_Attachment::newInstance()
                    ->setFilename('adjunto_' . $email . $asunto . '.' . $t[1])
                    ->setContentType($archivo['tipo'])
                    ->setBody(base64_decode($archivo['base64']));
            $message->attach($attach);
        }
        $message->setBody(
                $this->renderView(
                        // app/Resources/views/Emails/registration.html.twig
                        'Emails/contacto.html.twig', array('mensaje' => $mensaje, 'nombre' => $nombre, 'tel' => $tel)
                ), 'text/html'
        )
        /*
         * If you also want to include a plaintext version of the message
          ->addPart(
          $this->renderView(
          'Emails/registration.txt.twig',
          array('name' => $name)
          ),
          'text/plain'
          )
         */
        ;

//        echo $message;
//        
//        $this->get('mailer')->send($message);
        $mailer = $this->get('mailer');

        $mailer->send($message);

        $spool = $mailer->getTransport()->getSpool();
        $transport = $this->get('swiftmailer.transport.real');

        $spool->flushQueue($transport);
    }

}

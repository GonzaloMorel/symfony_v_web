<?php

namespace WebVerantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WebVerantBundle\Entity\Contacto;
use WebVerantBundle\Form\ContactoType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Contacto controller.
 *
 */
class ContactoController extends Controller {

    /**
     * Lists all Contacto entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT c FROM WebVerantBundle:Contacto c order by c.createdAt desc";

        $contacto = $em->createQuery($dql);

        $paginador = $this->get('knp_paginator');
        $paginacion = $paginador->paginate(
                $contacto, $request->query->getInt('page', 1), 5
        );

        return $this->render('contacto/index.html.twig', array(
                    'pagination' => $paginacion,
        ));
    }

    /**
     * Creates a new Contacto entity.
     *
     */
    public function newAction(Request $request)
    {
        $contacto = new Contacto();
        $form = $this->createForm('WebVerantBundle\Form\ContactoType', $contacto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($contacto);
            $em->flush();

            return $this->redirectToRoute('contacto_show', array('id' => $contacto->getId()));
        }

        return $this->render('contacto/new.html.twig', array(
                    'contacto' => $contacto,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Contacto entity.
     *
     */
    public function showAction(Contacto $contacto)
    {
        $deleteForm = $this->createDeleteForm($contacto);


        $file = $contacto->getArchivo();
        $tipo = $contacto->getArchivoTipo();
        $extension = "";
        if ($file) {
            $extension = explode('/', $tipo);
            $extension = $extension[1];
        }
//        echo $extension;
//        die();

        $response = new Response();

        $response->headers->set('Content-Type', "'.$tipo.'");
        $response->headers->set("Content-Type", "application/force-download");
        $response->headers->set('Content-Disposition', 'attachment; filename="archivo.' . $extension . '"');

        return $this->render('contacto/show.html.twig', array(
                    'contacto' => $contacto,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Contacto entity.
     *
     */
    public function editAction(Request $request, Contacto $contacto)
    {
        $deleteForm = $this->createDeleteForm($contacto);
        $editForm = $this->createForm('WebVerantBundle\Form\ContactoType', $contacto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contacto);
            $em->flush();

            return $this->redirectToRoute('contacto_edit', array('id' => $contacto->getId()));
        }

        return $this->render('contacto/edit.html.twig', array(
                    'contacto' => $contacto,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Contacto entity.
     *
     */
    public function deleteAction(Request $request, Contacto $contacto)
    {
        $form = $this->createDeleteForm($contacto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contacto);
            $em->flush();
        }

        return $this->redirectToRoute('contacto_index');
    }

    /**
     * Creates a form to delete a Contacto entity.
     *
     * @param Contacto $contacto The Contacto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Contacto $contacto)
    {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('contacto_delete', array('id' => $contacto->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    /**
     * Recibo un contacto desde la web
     * @param Request $request
     * @return type
     */
    public function reciboContactoAction(Request $request)
    {
        
        set_time_limit(300);
        
        if ($request->getMethod() == 'POST') {

            $data = $this->getRequest()->request->get('contact'); // obtengo todos los objetos request del formulario
            $file = $this->getRequest()->files->get('contact'); // obtengo el archivo del formulario

            $nombre = $data['nombre']['required'];
            $email = $data['email']['required'];
            $telefono = $data['telefono'];
            $asunto = $data['asunto']['required'];
            $mensaje = $data['mensaje'];


            $contacto = new Contacto();


            if ($file['archivo'] && $file['archivo']->getError() == 0) {

                $archivo = $this->fileToBase64($file['archivo']);


                $arch = $archivo['base64'];
                $tip = $archivo['tipo'];
                $tipo = explode('/', $archivo['tipo']);

                $validos = array('pdf', 'jpg', 'jpeg', 'png');

                if (!in_array(strtolower($tipo[1]), $validos)) {

                    $this->get('session')->getFlashBag()->add("mensaje", "El Archivo que intentó subir no está permitido");
                    return $this->redirectToRoute('web_verant_contact');
                } else {

                    if ($file['archivo']->getSize() <= 10485760) {

                        $contacto->setArchivo($arch);
                        $contacto->setArchivoTipo($tip);
                    } else {
                        $this->get('session')->getFlashBag()->add("mensaje", "El Archivo es demasiado pesado");
                        return $this->redirectToRoute('web_verant_contact');
                    }
                }
            } else {
                if ($file['archivo'] == "") {
                    $archivo = "";
                } else {
                    $this->get('session')->getFlashBag()->add("mensaje", "Existió un error con el archivo, favor reintente");
                    return $this->redirectToRoute('web_verant_contact');
                }
            }


//            echo "hubo un error";
//            exit();
            $this->sendMail($nombre, $email, $telefono, $asunto, $mensaje, $archivo);



            $contacto->setNombre($nombre);
            $contacto->setEmail($email);
            $contacto->setTelefono($telefono);
            $contacto->setAsunto($asunto);
            $contacto->setMensaje($mensaje);

            $contacto->setIsActive(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($contacto);
            $em->flush();

            $this->get('session')->getFlashBag()->add("mensaje", "El mensaje ha sido enviado");
            return $this->redirectToRoute('web_verant_contact');
        }
    }

    /**
     * Este metodo se encarga de envíar el correo electrónico 
     * @param type $nombre
     * @param type $email
     * @param type $tel
     * @param type $asunto
     * @param type $mensaje
     * @param type $archivo
     */
    private function sendMail($nombre, $email, $tel, $asunto, $mensaje, $archivo)
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
//        $this->get('mailer')->send($message);
        
        $mailer = $this->get('mailer');

        $mailer->send($message);

        $spool = $mailer->getTransport()->getSpool();
        $transport = $this->get('swiftmailer.transport.real');

        $spool->flushQueue($transport);
    }

    private function fileToBase64($file)
    {

        $tipo = $file->getMimeType();
        $originalName = $file->getClientOriginalName();
        $path = file_get_contents($file->getPathname());
        $base64 = base64_encode($path);
        return array('tipo' => $tipo, 'base64' => $base64, 'originalName' => $originalName);
    }

}

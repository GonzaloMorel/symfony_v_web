<?php

namespace WebVerantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WebVerantBundle\Entity\Pregunta;
use WebVerantBundle\Entity\Contenido;
use WebVerantBundle\Entity\Faq;
use WebVerantBundle\Entity\Horario;
use WebVerantBundle\Entity\Contacto;
use WebVerantBundle\Entity\DatosVerant;
use WebVerantBundle\Entity\TextoCita;
use VerantBundle\Entity\Usuario;
use VerantBundle\Entity\Empresa;
use VerantBundle\Entity\Provincias;
use WebVerantBundle\Form\PreguntaType;

class DefaultController extends Controller {

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $contenido_p = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
                    'despliegue' => 'HOME',
                    'posicion' => 'PRIMARIO',
                    'isActive' => true)
        );
        $contenido_s = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
                    'despliegue' => 'HOME',
                    'posicion' => 'SECUNDARIO',
                    'isActive' => true)
        );

        $verant = $em->getRepository('WebVerantBundle:DatosVerant')->findBy(
                array('isActive' => true)
        );

        $hora = $em->getRepository('WebVerantBundle:Horario')->findBy(
                array('isActive' => true));

        $terminos = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
                    'despliegue' => 'TERMINOS',
                    'isActive' => true)
        );

        return $this->render('WebVerantBundle:Verant:home.html.twig', array(
                    'primario' => $contenido_p,
                    'secundario' => $contenido_s,
                    'verant' => $verant,
                    'horario' => $hora,
                    'terminos' => $terminos
        ));
    }

    public function serviceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        $personas_pri = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
                    'despliegue' => 'SERV_PERS',
                    'posicion' => 'PRIMARIO',
                    'isActive' => true)
        );
        $personas_sec = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
                    'despliegue' => 'SERV_PERS',
                    'posicion' => 'SECUNDARIO',
                    'isActive' => true)
        );

        $servicios_p = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
            'despliegue' => 'SERV_PERS',
            'posicion' => 'SERVICIO',
            'isActive' => true), array('orden' => 'ASC')
        );

        $procesos_p = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
            'despliegue' => 'SERV_PERS',
            'posicion' => 'PROCESO',
            'isActive' => true), array('orden' => 'ASC')
        );

        $empresas_pri = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
                    'despliegue' => 'SERV_EMP',
                    'posicion' => 'PRIMARIO',
                    'isActive' => true)
        );

        $empresas_sec = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
                    'despliegue' => 'SERV_EMP',
                    'posicion' => 'SECUNDARIO',
                    'isActive' => true)
        );

        $servicios_e = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
            'despliegue' => 'SERV_EMP',
            'posicion' => 'SERVICIO',
            'isActive' => true), array('id' => 'ASC')
        );

        $procesos_e = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
            'despliegue' => 'SERV_EMP',
            'posicion' => 'PROCESO',
            'isActive' => true), array('id' => 'ASC')
        );

        $verant = $em->getRepository('WebVerantBundle:DatosVerant')->findBy(
                array('isActive' => true)
        );

        $hora = $em->getRepository('WebVerantBundle:Horario')->findBy(
                array('isActive' => true));

        $terminos = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
                    'despliegue' => 'TERMINOS',
                    'isActive' => true)
        );



        return $this->render('WebVerantBundle:Verant:services.html.twig', array(
                    'empresas_pri' => $empresas_pri,
                    'empresas_sec' => $empresas_sec,
                    'servicios_e' => $servicios_e,
                    'procesos_e' => $procesos_e,
                    'personas_pri' => $personas_pri,
                    'personas_sec' => $personas_sec,
                    'servicios_p' => $servicios_p,
                    'procesos_p' => $procesos_p,
                    'verant' => $verant,
                    'horario' => $hora,
                    'terminos' => $terminos
        ));
    }

    public function aboutAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $about_pri = $em->getRepository('WebVerantBundle:Contenido')->findBy(array(
            'despliegue' => 'ABOUT',
            'posicion' => 'PRIMARIO',
            'isActive' => true)
        );
        $about_sec = $em->getRepository('WebVerantBundle:Contenido')->findBy(array(
            'despliegue' => 'ABOUT',
            'posicion' => 'SECUNDARIO',
            'isActive' => true)
        );

        $usuarios = $em->getRepository('VerantBundle:Usuario')->findBy(array(
            'tipo' => 'USU_VERANT',
            'publico' => true,
            'isActive' => true
        ));

        $verant = $em->getRepository('WebVerantBundle:DatosVerant')->findBy(
                array('isActive' => true)
        );

        $clientes = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array('isActive' => true,
                    'posicion' => 'CLIENTE')
        );

        $hora = $em->getRepository('WebVerantBundle:Horario')->findBy(
                array('isActive' => true));

        $terminos = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
                    'despliegue' => 'TERMINOS',
                    'isActive' => true)
        );


        return $this->render('WebVerantBundle:Verant:about.html.twig', array(
                    'about_pri' => $about_pri,
                    'about_sec' => $about_sec,
                    'verant' => $verant,
                    'horario' => $hora,
                    'clientes' => $clientes,
                    'usuarios' => $usuarios,
                    'terminos' => $terminos
        ));
    }

    public function faqAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $faq_pri = $em->getRepository('WebVerantBundle:Contenido')->findBy(array(
            'despliegue' => 'FAQ',
            'posicion' => 'PRIMARIO',
            'isActive' => true)
        );

        $faq_sec = $em->getRepository('WebVerantBundle:Contenido')->findBy(array(
            'despliegue' => 'FAQ',
            'posicion' => 'SECUNDARIO',
            'isActive' => true)
        );

        $preguntas = $em->getRepository('WebVerantBundle:Faq')->findBy(
                array('isActive' => true), array('id' => 'ASC'));

        $verant = $em->getRepository('WebVerantBundle:DatosVerant')->findBy(
                array('isActive' => true)
        );

        $hora = $em->getRepository('WebVerantBundle:Horario')->findBy(
                array('isActive' => true));

        $terminos = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
                    'despliegue' => 'TERMINOS',
                    'isActive' => true)
        );

        $preguntum = new Pregunta();
        $form = $this->createForm('WebVerantBundle\Form\PreguntaType', $preguntum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($preguntum);
            $em->flush();


            $this->get('session')->getFlashBag()->add("mensaje", "Pregunta enviada");
            return $this->redirectToRoute('web_verant_faq', array('id' => $preguntum->getId()));
        }

        return $this->render('WebVerantBundle:Verant:faq.html.twig', array(
                    'faq_pri' => $faq_pri,
                    'faq_sec' => $faq_sec,
                    'preguntas' => $preguntas,
                    'verant' => $verant,
                    'horario' => $hora,
                    'terminos' => $terminos,
                    'form' => $form->createView())
        );
    }

    public function contactAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $contacto_pri = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
                    'despliegue' => 'CONTACT',
                    'posicion' => 'PRIMARIO',
                    'isActive' => true)
        );

        $contacto_sec = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
                    'despliegue' => 'CONTACT',
                    'posicion' => 'SECUNDARIO',
                    'isActive' => true)
        );

        $verant = $em->getRepository('WebVerantBundle:DatosVerant')->findBy(
                array('isActive' => true)
        );

        $hora = $em->getRepository('WebVerantBundle:Horario')->findBy(
                array('isActive' => true));

        $terminos = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
                    'despliegue' => 'TERMINOS',
                    'isActive' => true)
        );

        return $this->render('WebVerantBundle:Verant:contact.html.twig', array(
                    'contacto_pri' => $contacto_pri,
                    'contacto_sec' => $contacto_sec,
                    'verant' => $verant,
                    'horario' => $hora,
                    'terminos' => $terminos
                        )
        );
    }

    public function loginAction(Request $request)
    {
        $usuario = new Usuario();
        $form = $this->createForm('VerantBundle\Form\UsuarioNaturalType', $usuario);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        $terminos = $em->getRepository('WebVerantBundle:Contenido')->findBy(array(
            'despliegue' => 'TERMINOS',
            'isActive' => true
        ));

        $verant = $em->getRepository('WebVerantBundle:DatosVerant')->findBy(
                array('isActive' => true)
        );

        $hora = $em->getRepository('WebVerantBundle:Horario')->findBy(
                array('isActive' => true));

        $terminos = $em->getRepository('WebVerantBundle:Contenido')->findBy(
                array(
                    'despliegue' => 'TERMINOS',
                    'isActive' => true)
        );

        return $this->render('WebVerantBundle:Verant:login.html.twig', array(
                    'terminos' => $terminos,
                    'verant' => $verant,
                    'horario' => $hora,
                    'terminos' => $terminos
        ));
    }

    public function newPreguntaAction(Request $request)
    {
        $preguntum = new Pregunta();
        $form = $this->createForm('WebVerantBundle\Form\PreguntaType', $preguntum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($preguntum);
            $em->flush();

            return $this->redirectToRoute('web_verant_pregunta', array('id' => $pregunta->getId()));
        }

        return $this->render('WebVerantBundle:Verant:faq.html.twig', array(
                    'preguntum' => $preguntum,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Metodo para loggin
     * @param Request $request
     * @return type
     */
    public function loginAccessAction(Request $request)
    {

        $usuario = new Usuario();
        if ($request->getMethod() == "POST") {
            $login = $request->get('login');

            $rut = $login['rut'];

            $rut = explode('-', $rut);
            $dv = $rut[1];
            $rut = str_replace('.', '', $rut[0]);

            $password = $login['password']; //obtengo el dato

            $password = md5($password);
            $em = $this->getDoctrine()->getManager();

            $res = $em->getRepository('VerantBundle:Usuario')->findOneBy(array('rut' => $rut, 'password' => $password));
            if ($res) {
                $session = $request->getSession();
                $session->set("id", $res->getId());
                $session->set("nombres", $res->getNombres());
                $session->set("apPat", $res->getApPat());
                $session->set("apMat", $res->getApMat());
                $session->set("rut", $res->getRut() . "-" . $res->getDv());
                $session->set("email", $res->getEmail());
                $session->set("tipo", $res->getTipo());
                $session->set("login", true);

                if ($res->getTipo() == "USU_VERANT") {

                    $this->get('session')->getFlashBag()->add("mensaje", "Bienvenido");
                    return $this->redirect($this->generateUrl('contacto_index'));
                } else {

                    $this->get('session')->getFlashBag()->add("mensaje", "Usuario Logueado");
                    return $this->redirect($this->generateUrl('web_verant_login'));
                }
            } else {
                $this->get('session')->getFlashBag()->add("mensaje", "Los Datos No Son Válidos");
                return $this->redirect($this->generateUrl('web_verant_login'));
            }
        }

        return $this->render('WebVerantBundle:Verant:login.html.twig');
    }

    /**
     * Metodo para deslogueo
     * @param Request $request
     * @return type
     */
    public function logoutAction(Request $request)
    {
        $session = $request->getSession();
        $session->clear();

        $this->get('session')->getFlashBag()->add("mensaje", "Se ha cerrado la session");
        return $this->redirect($this->generateUrl('web_verant_login'));
    }

}

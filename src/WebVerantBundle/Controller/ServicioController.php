<?php
namespace WebVerantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use WebVerantBundle\Entity\Contenido;
use WebVerantBundle\Form\ServiciosType;

/**
 * Contenido controller.
 *
 */
class ServicioController extends Controller
{
    /**
     * Lists all Contenido entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $dql = "SELECT c FROM WebVerantBundle:Contenido c WHERE c.posicion = :posicion order by c.id";
        
        $contenido = $em->createQuery($dql)
                ->setParameters(array(
                    'posicion' => 'SERVICIO'
                ));
        
        $paginador = $this->get('knp_paginator');
        $paginacion = $paginador->paginate(
                $contenido, $request->query->getInt('page', 1), 
                6
                );

//        $contenidos = $em->getRepository('WebVerantBundle:Contenido')->findByPosicion('SERVICIO');

        return $this->render('servicio/index.html.twig', array(
            'pagination' => $paginacion
//            'contenidos' => $contenidos,
        ));
    }
    
    /**
     * Creación de Servicios
     *
     */
    public function newAction(Request $request){
        $contenido = new Contenido();
        
        $form = $this->createForm('WebVerantBundle\Form\ServiciosType', $contenido);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contenido);
            $em->flush();

            return $this->redirectToRoute('servicio_index', array('id' => $contenido->getId()));
        }

        return $this->render('servicio/new.html.twig', array(
            'contenido' => $contenido,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Finds and displays a Contenido entity.
     *
     */
    public function showAction(Contenido $contenido)
    {
        $deleteForm = $this->createDeleteForm($contenido);

        return $this->render('servicio/show.html.twig', array(
            'contenido' => $contenido,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Contenido entity.
     *
     */
    public function editAction(Request $request, Contenido $contenido)
    {
        $deleteForm = $this->createDeleteForm($contenido);
        $editForm = $this->createForm('WebVerantBundle\Form\ServiciosType', $contenido);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contenido);
            $em->flush();

            return $this->redirectToRoute('servicio_index', array('id' => $contenido->getId()));
        }

        return $this->render('servicio/edit.html.twig', array(
            'contenido' => $contenido,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Contenido entity.
     *
     */
    public function deleteAction(Request $request, Contenido $contenido)
    {
        $form = $this->createDeleteForm($contenido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contenido);
            $em->flush();
        }

        return $this->redirectToRoute('servicio_index');
    }

    /**
     * Creates a form to delete a Contenido entity.
     *
     * @param Contenido $contenido The Contenido entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Contenido $contenido)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('servicio_delete', array('id' => $contenido->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

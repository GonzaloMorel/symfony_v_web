<?php

namespace WebVerantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use WebVerantBundle\Entity\Contenido;
use WebVerantBundle\Form\ProcesoType;

/**
 * Contenido controller.
 *
 */
class ProcesoController extends Controller
{
    /**
     * Lists all Contenido entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT c FROM WebVerantBundle:Contenido c WHERE c.posicion = :posicion";
        
        $contenido = $em->createQuery($dql)
                ->setParameters(array(
                    'posicion' => 'PROCESO'
                ));
        
        $paginador = $this->get('knp_paginator');
        $paginacion = $paginador->paginate(
                $contenido, $request->query->getInt('page', 1), 
                5
                );
        
//        $contenidos = $em->getRepository('WebVerantBundle:Contenido')->findByPosicion('PROCESO');

        return $this->render('proceso/index.html.twig', array(
            'pagination' => $paginacion
//            'contenidos' => $contenidos,
        ));
    }
    
    /**
     * Creates a new Contenido entity.
     *
     */
    public function newAction(Request $request)
    {
        $contenido = new Contenido();
        $form = $this->createForm('WebVerantBundle\Form\ProcesoType', $contenido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contenido);
            $em->flush();

            return $this->redirectToRoute('proceso_index', array('id' => $contenido->getId()));
        }

        return $this->render('proceso/new.html.twig', array(
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

        return $this->render('proceso/show.html.twig', array(
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
        $editForm = $this->createForm('WebVerantBundle\Form\ProcesoType', $contenido);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contenido);
            $em->flush();

            return $this->redirectToRoute('proceso_index', array('id' => $contenido->getId()));
        }

        return $this->render('proceso/edit.html.twig', array(
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

        return $this->redirectToRoute('proceso_index');
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
            ->setAction($this->generateUrl('proceso_delete', array('id' => $contenido->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    
    
}

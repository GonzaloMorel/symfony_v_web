<?php

namespace WebVerantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use WebVerantBundle\Entity\Pregunta;
use WebVerantBundle\Form\PreguntaType;

/**
 * Pregunta controller.
 *
 */
class PreguntaController extends Controller
{
    /**
     * Lists all Pregunta entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $dql = "SELECT p FROM WebVerantBundle:Pregunta p ORDER BY p.createdAt DESC";
        
        $resp = $em->createQuery($dql);
        
        $paginador = $this->get('knp_paginator');
        $paginacion = $paginador->paginate(
                $resp, $request->query->getInt('page', 1), 
                5
                );

        return $this->render('pregunta/index.html.twig', array(
            'pagination' => $paginacion,
        ));
    }

    /**
     * Creates a new Pregunta entity.
     *
     */
    public function newAction(Request $request)
    {
        $preguntum = new Pregunta();
        $form = $this->createForm('WebVerantBundle\Form\PreguntaType', $preguntum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($preguntum);
            $em->flush();
            
            
            $this->get('session')->getFlashBag()->add("mensaje", "Gracias por enviarnos su pregunta."); //mensaje para loguearse

            return $this->redirectToRoute('pregunta_new', array('id' => $pregunta->getId()));
        }

        return $this->render('pregunta/new.html.twig', array(
            'preguntum' => $preguntum,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Pregunta entity.
     *
     */
    public function showAction(Pregunta $preguntum)
    {
        $deleteForm = $this->createDeleteForm($preguntum);

        return $this->render('pregunta/show.html.twig', array(
            'preguntum' => $preguntum,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Pregunta entity.
     *
     */
    public function editAction(Request $request, Pregunta $preguntum)
    {
        $deleteForm = $this->createDeleteForm($preguntum);
        $editForm = $this->createForm('WebVerantBundle\Form\PreguntaType', $preguntum);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($preguntum);
            $em->flush();

            return $this->redirectToRoute('pregunta_edit', array('id' => $preguntum->getId()));
        }

        return $this->render('pregunta/edit.html.twig', array(
            'preguntum' => $preguntum,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Pregunta entity.
     *
     */
    public function deleteAction(Request $request, Pregunta $preguntum)
    {
        $form = $this->createDeleteForm($preguntum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($preguntum);
            $em->flush();
        }

        return $this->redirectToRoute('pregunta_index');
    }

    /**
     * Creates a form to delete a Pregunta entity.
     *
     * @param Pregunta $preguntum The Pregunta entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pregunta $preguntum)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pregunta_delete', array('id' => $preguntum->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace WebVerantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use WebVerantBundle\Entity\Horario;
use WebVerantBundle\Form\HorarioType;

/**
 * Horario controller.
 *
 */
class HorarioController extends Controller
{
    /**
     * Lists all Horario entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $dql = "SELECT h FROM WebVerantBundle:Horario h";
        
        $contenido = $em->createQuery($dql);
        
        $paginador = $this->get('knp_paginator');
        $paginacion = $paginador->paginate(
                $contenido, $request->query->getInt('page', 1), 
                10
                );

//        $horarios = $em->getRepository('WebVerantBundle:Horario')->findAll();

        return $this->render('horario/index.html.twig', array(
            'pagination' => $paginacion
//            'horarios' => $horarios,
        ));
    }

    /**
     * Creates a new Horario entity.
     *
     */
    public function newAction(Request $request)
    {
        $horario = new Horario();
        $form = $this->createForm('WebVerantBundle\Form\HorarioType', $horario);
        $form->handleRequest($request);

        
        
        if ($form->isSubmitted() && $form->isValid()) {
            
//            $desde = $form->get('horaDesde')->getData();
//            $hasta = $form->get('horaHasta')->getData();
//            echo $desde." - ".$hasta;
//            exit();
        
            $em = $this->getDoctrine()->getManager();
            $em->persist($horario);
            $em->flush();

            return $this->redirectToRoute('horario_show', array('id' => $horario->getId()));
        }

        return $this->render('horario/new.html.twig', array(
            'horario' => $horario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Horario entity.
     *
     */
    public function showAction(Horario $horario)
    {
        $deleteForm = $this->createDeleteForm($horario);

        return $this->render('horario/show.html.twig', array(
            'horario' => $horario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Horario entity.
     *
     */
    public function editAction(Request $request, Horario $horario)
    {
        $deleteForm = $this->createDeleteForm($horario);
        $editForm = $this->createForm('WebVerantBundle\Form\HorarioType', $horario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($horario);
            $em->flush();

            return $this->redirectToRoute('horario_edit', array('id' => $horario->getId()));
        }

        return $this->render('horario/edit.html.twig', array(
            'horario' => $horario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Horario entity.
     *
     */
    public function deleteAction(Request $request, Horario $horario)
    {
        $form = $this->createDeleteForm($horario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($horario);
            $em->flush();
        }

        return $this->redirectToRoute('horario_index');
    }

    /**
     * Creates a form to delete a Horario entity.
     *
     * @param Horario $horario The Horario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Horario $horario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('horario_delete', array('id' => $horario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

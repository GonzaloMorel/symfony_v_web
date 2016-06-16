<?php

namespace WebVerantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

use WebVerantBundle\Entity\Faq;
use WebVerantBundle\Form\FaqType;

/**
 * Faq controller.
 *
 */
class FaqController extends Controller
{
    /**
     * Lists all Faq entities.
     *
     */
    public function indexAction(Request $request)
    {
        
        
        $em = $this->getDoctrine()->getManager();
        
        $dql = "SELECT f FROM WebVerantBundle:Faq f";
        
        $contenido = $em->createQuery($dql);
        
        $paginador = $this->get('knp_paginator');
        $paginacion = $paginador->paginate(
                $contenido, $request->query->getInt('page', 1), 
                10
                );

//        $faqs = $em->getRepository('WebVerantBundle:Faq')->findAll();

        return $this->render('faq/index.html.twig', array(
//            'faqs' => $faqs,
            'pagination' => $paginacion
        ));
    }

    /**
     * Creates a new Faq entity.
     *
     */
    public function newAction(Request $request)
    {
        $faq = new Faq();
        $form = $this->createForm('WebVerantBundle\Form\FaqType', $faq);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($faq);
            $em->flush();

            return $this->redirectToRoute('faq_show', array('id' => $faq->getId()));
        }

        return $this->render('faq/new.html.twig', array(
            'faq' => $faq,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Faq entity.
     *
     */
    public function showAction(Faq $faq)
    {
        $deleteForm = $this->createDeleteForm($faq);

        return $this->render('faq/show.html.twig', array(
            'faq' => $faq,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Faq entity.
     *
     */
    public function editAction(Request $request, Faq $faq)
    {
        $deleteForm = $this->createDeleteForm($faq);
        $editForm = $this->createForm('WebVerantBundle\Form\FaqType', $faq);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($faq);
            $em->flush();

            return $this->redirectToRoute('faq_edit', array('id' => $faq->getId()));
        }

        return $this->render('faq/edit.html.twig', array(
            'faq' => $faq,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Faq entity.
     *
     */
    public function deleteAction(Request $request, Faq $faq)
    {
        $form = $this->createDeleteForm($faq);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($faq);
            $em->flush();
        }

        return $this->redirectToRoute('faq_index');
    }

    /**
     * Creates a form to delete a Faq entity.
     *
     * @param Faq $faq The Faq entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Faq $faq)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('faq_delete', array('id' => $faq->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

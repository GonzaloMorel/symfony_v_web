<?php

namespace VerantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VerantBundle\Entity\Provincias;
use VerantBundle\Form\ProvinciasType;

/**
 * Provincias controller.
 *
 */
class ProvinciasController extends Controller {

    /**
     * Lists all Provincias entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $provincias = $em->getRepository('VerantBundle:Provincias')->findAll();

        return $this->render('provincias/index.html.twig', array(
                    'provincias' => $provincias,
        ));
    }

    /**
     * Creates a new Provincias entity.
     *
     */
    public function newAction(Request $request)
    {
        $provincia = new Provincias();
        $form = $this->createForm('VerantBundle\Form\ProvinciasType', $provincia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($provincia);
            $em->flush();

            return $this->redirectToRoute('provincias_show', array('id' => $provincias->getId()));
        }

        return $this->render('provincias/new.html.twig', array(
                    'provincia' => $provincia,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Provincias entity.
     *
     */
    public function showAction(Provincias $provincia)
    {
        $deleteForm = $this->createDeleteForm($provincia);

        return $this->render('provincias/show.html.twig', array(
                    'provincia' => $provincia,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Provincias entity.
     *
     */
    public function editAction(Request $request, Provincias $provincia)
    {
        $deleteForm = $this->createDeleteForm($provincia);
        $editForm = $this->createForm('VerantBundle\Form\ProvinciasType', $provincia);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($provincia);
            $em->flush();

            return $this->redirectToRoute('provincias_edit', array('id' => $provincia->getId()));
        }

        return $this->render('provincias/edit.html.twig', array(
                    'provincia' => $provincia,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Provincias entity.
     *
     */
    public function deleteAction(Request $request, Provincias $provincia)
    {
        $form = $this->createDeleteForm($provincia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($provincia);
            $em->flush();
        }

        return $this->redirectToRoute('provincias_index');
    }

    /**
     * Creates a form to delete a Provincias entity.
     *
     * @param Provincias $provincia The Provincias entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Provincias $provincia)
    {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('provincias_delete', array('id' => $provincia->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }


    public function comunaAction(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();

            $dql = "SELECT c FROM VerantBundle:Provincias c WHERE c.padrePrv = '$id'";
            $query = $em->createQuery($dql);
            $ciudades = $query->getResult();

            $ciu = array();

            foreach ($ciudades as $ciudad):

                $ciu[] = array(
                    'id' => $ciudad->getIdPrv(),
                    'codigo' => $ciudad->getCodigoPrv(),
                    'nombre' => $ciudad->getNombrePrv(),
                    'orden' => $ciudad->getOrdenPrv()
                );

            endforeach;

            $response = new Response(json_encode(array(array('id' => 1, 'nombre' => 'loquesea'))));
            $response = new Response(json_encode($ciu));
            $response->headers->set('content-type', 'application/json');
            return $response;
        }
    }


}

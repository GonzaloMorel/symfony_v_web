<?php

namespace WebVerantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use WebVerantBundle\Entity\Contenido;
use WebVerantBundle\Form\ContenidoType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Contenido controller.
 *
 */
class ContenidoController extends Controller
{
    /**
     * Lists all Contenido entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $dql = "SELECT c FROM WebVerantBundle:Contenido c WHERE c.posicion = :posicion OR c.posicion = :posicion2 order by c.despliegue asc";
        
        $contenido = $em->createQuery($dql)
                ->setParameters(array(
                    'posicion' => 'PRIMARIO',
                    'posicion2' => 'SECUNDARIO'
                ));
        
        $paginador = $this->get('knp_paginator');
        $paginacion = $paginador->paginate(
                $contenido, $request->query->getInt('page', 1), 
                15
                );

//        $contenidos = $em->getRepository('WebVerantBundle:Contenido')->findByPosicion(array('PRIMARIO', 'SECUNDARIO'));

        return $this->render('contenido/index.html.twig', array(
            'pagination' => $paginacion,
        ));
    }
    
    /**
     * Creates a new Contenido entity.
     *
     */
    public function newAction(Request $request)
    {
        $contenido = new Contenido();
        $form = $this->createForm('WebVerantBundle\Form\ContenidoType', $contenido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $imagen = $form->get('imagen')->getData();
                           
            if(($imagen instanceof UploadedFile) && $imagen->getError() == 0){
                
                $tipo = $imagen->getMimeType();
                $file = file_get_contents($imagen->getPathname());
                $base64 = base64_encode($file);
                $contenido->setImagenTipo($tipo);
                $contenido->setImagen($base64);
                
//                echo "<img src='data:".$imagen->getMimeType().";base64,".$base64."' height='400'/>";

            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($contenido);
            $em->flush();
            

            $this->addFlash('mensaje', 'Registro crerado con exito!!!.');
            return $this->redirectToRoute('contenido_show', array('id' => $contenido->getId()));
        }

        return $this->render('contenido/new.html.twig', array(
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
        
        
        
        return $this->render('contenido/show.html.twig', array(
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
        $editForm = $this->createForm('WebVerantBundle\Form\ContenidoType', $contenido);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            
            $imagen = $editForm->get('imagen')->getData();
            if($imagen){              
                if(($imagen instanceof UploadedFile) && $imagen->getError() == 0){

                    $tipo = $imagen->getMimeType();
                    $file = file_get_contents($imagen->getPathname());
                    $base64 = base64_encode($file);
                    $contenido->setImagenTipo($tipo);
                    $contenido->setImagen($base64);

    //                echo "<img src='data:".$imagen->getMimeType().";base64,".$base64."' height='400'/>";

                }
                else {
                        $imagenRecover = $this->recoverImage($contenido->getId());
                        if($imagenRecover){
                        $imagenI = stream_get_contents($imagenRecover[0]['imagen']);
                        $tipoI = $imagenRecover[0]['imagenTipo'];

                        $contenido->setImagenTipo($tipoI);
                        $contenido->setImagen($imagenI);
                        }else{
                            $contenido->setImagenTipo(null);
                        $contenido->setImagen(null);
                        }
                    }
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($contenido);
            $em->flush();

            return $this->redirectToRoute('contenido_index', array('id' => $contenido->getId()));
        }

        return $this->render('contenido/edit.html.twig', array(
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

        return $this->redirectToRoute('contenido_index');
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
            ->setAction($this->generateUrl('contenido_delete', array('id' => $contenido->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    private function recoverImage($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "Select c.imagen, c.imagenTipo from WebVerantBundle:Contenido c Where c.id = :id")->setParameter('id', $id);

        $currentImage = $query->getResult();

        return $currentImage;
    }
    
}

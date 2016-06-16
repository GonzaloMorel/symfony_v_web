<?php

namespace WebVerantBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use WebVerantBundle\Entity\DatosVerant;
use WebVerantBundle\Form\DatosVerantType;

/**
 * DatosVerant controller.
 *
 */
class DatosVerantController extends Controller
{
    /**
     * Lists all DatosVerant entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $datosVerants = $em->getRepository('WebVerantBundle:DatosVerant')->findAll();

        return $this->render('datosverant/index.html.twig', array(
            'datosVerants' => $datosVerants,
        ));
    }

    /**
     * Creates a new DatosVerant entity.
     *
     */
    public function newAction(Request $request)
    {
        $datosVerant = new DatosVerant();
        $form = $this->createForm('WebVerantBundle\Form\DatosVerantType', $datosVerant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
//            $logo = $form->get('logo')->getData();
//                           
//            if(($logo instanceof UploadedFile) && $logo->getError() == 0){
//                
//                $tipo = $logo->getMimeType();
//                $file = file_get_contents($logo->getPathname());
//                $base64 = base64_encode($file);
//                $datosVerant->setLogoTipo($tipo);
//                $datosVerant->setLogo($base64);
//                
////                echo "<img src='data:".$imagen->getMimeType().";base64,".$base64."' height='400'/>";
//
//            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($datosVerant);
            $em->flush();

            return $this->redirectToRoute('datosverant_show', array('id' => $datosverant->getId()));
        }

        return $this->render('datosverant/new.html.twig', array(
            'datosVerant' => $datosVerant,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DatosVerant entity.
     *
     */
    public function showAction(DatosVerant $datosVerant)
    {
        $deleteForm = $this->createDeleteForm($datosVerant);

        return $this->render('datosverant/show.html.twig', array(
            'datosVerant' => $datosVerant,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DatosVerant entity.
     *
     */
    public function editAction(Request $request, DatosVerant $datosVerant)
    {
        $deleteForm = $this->createDeleteForm($datosVerant);
        
        $dv = $datosVerant->getDv();
        $rut = $this->puntosRut($datosVerant->getRut());
        $datosVerant->setRut($rut . '-' . $dv);
        
        $editForm = $this->createForm('WebVerantBundle\Form\DatosVerantType', $datosVerant);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            
            $terminos = $editForm->get('terminos')->getData();
            
            if(($terminos instanceof UploadedFile) && $terminos->getError() == 0){
                
                $tipo = $terminos->getMimeType();
                $file = file_get_contents($terminos->getPathname());
                $base64 = base64_encode($file);

                $datosVerant->setTerminosTipo($tipo);
                $datosVerant->setTerminos($base64);
            }
            else{
                    $imagenRecover = $this->recoverTerminos($datosVerant->getId());

                    $imagenI = stream_get_contents($imagenRecover[0]['terminos']);
                    $tipoI = $imagenRecover[0]['terminosTipo'];

                    $datosVerant->setTerminosTipo($tipoI);
                    $datosVerant->setTerminos($imagenI);
            }
//            
            //formateo de rut
            $rutF = $this->formatoRut($editForm->get('rut')->getData()); //tomo el rut y lo envío a la funcion formatoRut, la cual me devuelve el rut sin puntos y separado del dv
            $rut = $rutF['rut'];
            $dv = $rutF['dv'];
            $datosVerant->setRut($rut);
            $datosVerant->setDv($dv);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($datosVerant);
            $em->flush();

            return $this->redirectToRoute('datosverant_edit', array('id' => $datosVerant->getId()));
        }
        
        return $this->render('datosverant/edit.html.twig', array(
            'datosVerant' => $datosVerant,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a DatosVerant entity.
     *
     */
    public function deleteAction(Request $request, DatosVerant $datosVerant)
    {
        $form = $this->createDeleteForm($datosVerant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($datosVerant);
            $em->flush();
        }

        return $this->redirectToRoute('datosverant_index');
    }

    /**
     * Creates a form to delete a DatosVerant entity.
     *
     * @param DatosVerant $datosVerant The DatosVerant entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DatosVerant $datosVerant)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datosverant_delete', array('id' => $datosVerant->getId())))
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
        $u3 = substr($rut, strlen($rut)-3, strlen($rut));
        $s3 = substr($rut, strlen($rut)-6, strlen($rut)-5);
        $p3 = substr($rut, 0, strlen($rut)-6);
        return $p3.".".$s3.".".$u3;
    }
    
    private function recoverTerminos($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                        "Select dv.terminos, dv.terminosTipo from WebVerantBundle:DatosVerant dv Where dv.id = :id")->setParameter('id', $id);

        $currentImage = $query->getResult();

        return $currentImage;
    }
}

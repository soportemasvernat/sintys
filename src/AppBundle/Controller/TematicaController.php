<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Tematica;
use AppBundle\Form\TematicaType;

/**
 * Tematica controller.
 *
 * @Route("/tematica")
 */
class TematicaController extends Controller
{
    /**
     * Lists all Tematica entities.
     *
     * @Route("/", name="tematica_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tematicas = $em->getRepository('AppBundle:Tematica')->findAll();

        return $this->render('tematica/index.html.twig', array(
            'tematicas' => $tematicas,
        ));
    }

    /**
     * Creates a new Tematica entity.
     *
     * @Route("/new", name="tematica_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tematica = new Tematica();
        $form = $this->createForm('AppBundle\Form\TematicaType', $tematica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tematica);
            $em->flush();

            return $this->redirectToRoute('tematica_show', array('id' => $tematica->getId()));
        }

        return $this->render('tematica/new.html.twig', array(
            'tematica' => $tematica,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tematica entity.
     *
     * @Route("/{id}", name="tematica_show")
     * @Method("GET")
     */
    public function showAction(Tematica $tematica)
    {
        $deleteForm = $this->createDeleteForm($tematica);

        return $this->render('tematica/show.html.twig', array(
            'tematica' => $tematica,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Tematica entity.
     *
     * @Route("/{id}/edit", name="tematica_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tematica $tematica)
    {
        $deleteForm = $this->createDeleteForm($tematica);
        $editForm = $this->createForm('AppBundle\Form\TematicaType', $tematica);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tematica);
            $em->flush();

            return $this->redirectToRoute('tematica_edit', array('id' => $tematica->getId()));
        }

        return $this->render('tematica/edit.html.twig', array(
            'tematica' => $tematica,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Tematica entity.
     *
     * @Route("/{id}", name="tematica_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tematica $tematica)
    {
        $form = $this->createDeleteForm($tematica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tematica);
            $em->flush();
        }

        return $this->redirectToRoute('tematica_index');
    }

    /**
     * Creates a form to delete a Tematica entity.
     *
     * @param Tematica $tematica The Tematica entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tematica $tematica)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tematica_delete', array('id' => $tematica->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

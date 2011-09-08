<?php

namespace Iga\UniverseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Iga\UniverseBundle\Entity\FileType;
use Iga\UniverseBundle\Form\FileTypeType;

/**
 * FileType controller.
 *
 * @Route("/filetype")
 */
class FileTypeController extends Controller
{
    /**
     * Lists all FileType entities.
     *
     * @Route("/", name="filetype")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('IgaUniverseBundle:FileType')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a FileType entity.
     *
     * @Route("/{id}/show", name="filetype_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaUniverseBundle:FileType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FileType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new FileType entity.
     *
     * @Route("/new", name="filetype_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new FileType();
        $form   = $this->createForm(new FileTypeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new FileType entity.
     *
     * @Route("/create", name="filetype_create")
     * @Method("post")
     * @Template("IgaUniverseBundle:FileType:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new FileType();
        $request = $this->getRequest();
        $form    = $this->createForm(new FileTypeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('filetype_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing FileType entity.
     *
     * @Route("/{id}/edit", name="filetype_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaUniverseBundle:FileType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FileType entity.');
        }

        $editForm = $this->createForm(new FileTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing FileType entity.
     *
     * @Route("/{id}/update", name="filetype_update")
     * @Method("post")
     * @Template("IgaUniverseBundle:FileType:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaUniverseBundle:FileType')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FileType entity.');
        }

        $editForm   = $this->createForm(new FileTypeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('filetype_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a FileType entity.
     *
     * @Route("/{id}/delete", name="filetype_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('IgaUniverseBundle:FileType')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FileType entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('filetype'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

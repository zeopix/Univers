<?php

namespace Iga\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Iga\NewsBundle\Entity\Vendor;
use Iga\NewsBundle\Form\VendorType;
use Iga\NewsBundle\Util\Slug;

/**
 * Vendor controller.
 *
 * @Route("/admin/vendors")
 */
class VendorController extends Controller
{
    /**
     * Lists all Vendor entities.
     *
     * @Route("/", name="vendors")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('IgaNewsBundle:Vendor')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Vendor entity.
     *
     * @Route("/{id}/show", name="vendor_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaNewsBundle:Vendor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vendor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Vendor entity.
     *
     * @Route("/new", name="vendor_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Vendor();
        $form   = $this->createForm(new VendorType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Vendor entity.
     *
     * @Route("/create", name="vendor_create")
     * @Method("post")
     * @Template("IgaNewsBundle:Vendor:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Vendor();
        $request = $this->getRequest();
        $form    = $this->createForm(new VendorType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity->setCreatedAt(new \DateTime());
			$entity->setUpdatedAt(new \DateTime());
			$entity->setSlug(new Slug($entity->getTitle()));
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vendor_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Vendor entity.
     *
     * @Route("/{id}/edit", name="vendor_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaNewsBundle:Vendor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vendor entity.');
        }

        $editForm = $this->createForm(new VendorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Vendor entity.
     *
     * @Route("/{id}/update", name="vendor_update")
     * @Method("post")
     * @Template("IgaNewsBundle:Vendor:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaNewsBundle:Vendor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Vendor entity.');
        }

        $editForm   = $this->createForm(new VendorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vendor_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Vendor entity.
     *
     * @Route("/{id}/delete", name="vendor_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('IgaNewsBundle:Vendor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Vendor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('vendor'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

<?php

namespace Iga\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Iga\NewsBundle\Entity\Source;
use Iga\NewsBundle\Form\SourceType;
use Iga\NewsBundle\Util\Slug;

/**
 * Source controller.
 *
 * @Route("/admin/sources")
 */
class SourceController extends Controller
{
    /**
     * Lists all Source entities.
     *
     * @Route("/", name="sources")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('IgaNewsBundle:Source')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Source entity.
     *
     * @Route("/{id}/show", name="sources_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaNewsBundle:Source')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Source entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Source entity.
     *
     * @Route("/new", name="sources_new")
     * @Template()
     */
    public function newAction()
    {
    	$request = $this->getRequest();
    	
		$em = $this->getDoctrine()->getEntityManager();

    	$vendor = $request->get('vendor');
    	$vendor = $em->getRepository('IgaNewsBundle:Vendor')->find($vendor);
        
        $entity = new Source();
        $entity->setVendor($vendor);
        
        $form   = $this->createForm(new SourceType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Source entity.
     *
     * @Route("/create", name="sources_create")
     * @Method("post")
     * @Template("IgaNewsBundle:Source:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Source();
        $request = $this->getRequest();
        $form    = $this->createForm(new SourceType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity->setCreatedAt(new \DateTime());
			$entity->setUpdatedAt(new \DateTime());
			$entity->setCrawledAt(new \DateTime());
			$entity->setSlug(new Slug($entity->getTitle()));
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('crawl'));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Source entity.
     *
     * @Route("/{id}/edit", name="sources_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaNewsBundle:Source')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Source entity.');
        }

        $editForm = $this->createForm(new SourceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Source entity.
     *
     * @Route("/{id}/update", name="sources_update")
     * @Method("post")
     * @Template("IgaNewsBundle:Source:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaNewsBundle:Source')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Source entity.');
        }

        $editForm   = $this->createForm(new SourceType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('sources_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Source entity.
     *
     * @Route("/{id}/delete", name="sources_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('IgaNewsBundle:Source')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Source entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('sources'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

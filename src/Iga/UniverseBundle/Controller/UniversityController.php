<?php

namespace Iga\UniverseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Iga\UniverseBundle\Entity\University;
use Iga\UniverseBundle\Form\UniversityType;

use Iga\UniverseBundle\Util\Slug;

/**
 * University controller.
 *
 * @Route("/university")
 */
class UniversityController extends Controller
{
    /**
     * Lists all University entities.
     *
     * @Route("/", name="university")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('IgaUniverseBundle:University')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a University entity.
     *
     * @Route("/{id}/show", name="university_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaUniverseBundle:University')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find University entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new University entity.
     *
     * @Route("/new", name="university_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new University();
        $form   = $this->createForm(new UniversityType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new University entity.
     *
     * @Route("/create", name="university_create")
     * @Method("post")
     * @Template("IgaUniverseBundle:University:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new University();
        $request = $this->getRequest();
        $form    = $this->createForm(new UniversityType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            
            $entity->setSlug(new Slug($entity->getName()));
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('university_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing University entity.
     *
     * @Route("/{id}/edit", name="university_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaUniverseBundle:University')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find University entity.');
        }

        $editForm = $this->createForm(new UniversityType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing University entity.
     *
     * @Route("/{id}/update", name="university_update")
     * @Method("post")
     * @Template("IgaUniverseBundle:University:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaUniverseBundle:University')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find University entity.');
        }

        $editForm   = $this->createForm(new UniversityType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('university_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a University entity.
     *
     * @Route("/{id}/delete", name="university_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('IgaUniverseBundle:University')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find University entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('university'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

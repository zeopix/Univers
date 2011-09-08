<?php

namespace Iga\UniverseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Iga\UniverseBundle\Entity\Grade;
use Iga\UniverseBundle\Form\GradeType;

use Iga\UniverseBundle\Util\Slug;

/**
 * Grade controller.
 *
 * @Route("/grade")
 */
class GradeController extends Controller
{
    /**
     * Lists all Grade entities.
     *
     * @Route("/", name="grade")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('IgaUniverseBundle:Grade')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Grade entity.
     *
     * @Route("/{id}/show", name="grade_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaUniverseBundle:Grade')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Grade entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Grade entity.
     *
     * @Route("/new", name="grade_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Grade();
        $form   = $this->createForm(new GradeType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Grade entity.
     *
     * @Route("/create", name="grade_create")
     * @Method("post")
     * @Template("IgaUniverseBundle:Grade:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Grade();
        $request = $this->getRequest();
        $form    = $this->createForm(new GradeType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            
            $entity->setCreatedAt(new \DateTime());
            $entity->setUpdatedAt(new \DateTime());
            $entity->setSlug(new Slug($entity->getName()));
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('grade_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Grade entity.
     *
     * @Route("/{id}/edit", name="grade_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaUniverseBundle:Grade')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Grade entity.');
        }

        $editForm = $this->createForm(new GradeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Grade entity.
     *
     * @Route("/{id}/update", name="grade_update")
     * @Method("post")
     * @Template("IgaUniverseBundle:Grade:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaUniverseBundle:Grade')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Grade entity.');
        }

        $editForm   = $this->createForm(new GradeType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('grade_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Grade entity.
     *
     * @Route("/{id}/delete", name="grade_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('IgaUniverseBundle:Grade')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Grade entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('grade'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

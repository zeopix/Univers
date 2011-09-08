<?php

namespace Iga\UniverseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Iga\UniverseBundle\Entity\Career;
use Iga\UniverseBundle\Form\CareerType;

use Iga\UniverseBundle\Util\Slug;


/**
 * Career controller.
 *
 * @Route()
 */
class CareerController extends Controller
{
    /**
     * Lists all Career entities.
     *
     * @Route("/estudios", name="career")
     * @Template()
     */
    public function indexAction()
    {
    	  //          return $this->render('IgaUniverseBundle:Public:welcome.html.twig');

		//list careers
        $em = $this->getDoctrine()->getEntityManager();
        $entities = $em->getRepository('IgaUniverseBundle:Career')->findAll();
        
        //add career
        $entity = new Career();
        $form   = $this->createForm(new CareerType(), $entity);


        return array(
        	'entities' => $entities,
            'entity' => $entity,
            'form'   => $form->createView()
        	);
    }

    /**
     * Finds and displays a Career entity.
     *
     * @Route("/{slug}/show", name="career_show")
     * @Template()
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaUniverseBundle:Career')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Career entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }
    
    /**
     * Finds and displays a Career entity.
     *
     * @Route("/{slug}/follow", name="career_follow")
     * @Template()
     */
    public function followAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaUniverseBundle:Career')->findOneBySlug($slug);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Career entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Career entity.
     *
     * @Route("/new", name="career_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Career();
        $form   = $this->createForm(new CareerType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Career entity.
     *
     * @Route("/create", name="career_create")
     * @Method("post")
     * @Template("IgaUniverseBundle:Career:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Career();
        $request = $this->getRequest();
        $form    = $this->createForm(new CareerType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            
            
            $entity->setCreatedAt(new \DateTime());
            $entity->setUpdatedAt(new \DateTime());
            $entity->setSlug(new Slug($entity->getName()));
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('career'));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Career entity.
     *
     * @Route("/{id}/edit", name="career_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaUniverseBundle:Career')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Career entity.');
        }

        $editForm = $this->createForm(new CareerType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Career entity.
     *
     * @Route("/{id}/update", name="career_update")
     * @Method("post")
     * @Template("IgaUniverseBundle:Career:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaUniverseBundle:Career')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Career entity.');
        }

        $editForm   = $this->createForm(new CareerType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('career_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Career entity.
     *
     * @Route("/{id}/delete", name="career_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('IgaUniverseBundle:Career')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Career entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('career'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

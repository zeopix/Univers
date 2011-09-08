<?php

namespace Iga\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Iga\NewsBundle\Entity\Category;
use Iga\NewsBundle\Form\CategoryType;

use Symfony\Component\HttpFoundation\Response;


use Iga\NewsBundle\Util\Slug;


/**
 * Category controller.
 *
 * @Route("/admin/categories")
 */
class CategoryController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="categories")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('IgaNewsBundle:Category')->findByParent(1);

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{id}/show", name="categories_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaNewsBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Category entity.
     *
     * @Route("/new", name="categories_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Category();
        $form   = $this->createForm(new CategoryType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Category entity.
     *
     * @Route("/create", name="categories_create")
     * @Method("post")
     */
    public function createAction()
    {
        $entity  = new Category();
        $request = $this->getRequest();
        $form    = $this->createForm(new CategoryType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity->setCreatedAt(new \DateTime());
			$entity->setUpdatedAt(new \DateTime());
			$entity->setSlug(new Slug($entity->getTitle()));
            $em->persist($entity);
            
            $em->flush();

            return $this->redirect($this->generateUrl('categories_show', array('id' => $entity->getId())));
            
        }

		//TODO: do form validation properly
		if($request->isXmlHttpRequest()){
		
			//recibed ajax form, so don't check csrf
			
			//load em
			$em = $this->getDoctrine()->getEntityManager();

			//post data
			$title = $request->request->get('title');
			$parent = $request->request->get('parent');
			
			//get parent entity
			$parent = $em->getRepository('IgaNewsBundle:Category')->findOneById($parent);
			
			if($parent){
				
				//bind data
				$entity = new Category();
				$entity->setTitle($title);
				$entity->setSlug(new Slug($title));
				$entity->setCreatedAt(new \DateTime());
				$entity->setUpdatedAt(new \DateTime());
				$entity->setParent($parent);
			
            	$em->persist($entity);
            	$em->flush();
				
				$success = true;
			}else{
				$title = "ERROR: parent couldn't be found";
				$success = false;
			}
			
			$response = Array(
				'title' => $title,
				'success' => $success
			);
			
			return new Response(json_encode($response));	
			
		}
		
		
        return $this->render('IgaNewsBundle:Category:new.html.twig',array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     * @Route("/{id}/edit", name="categories_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaNewsBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createForm(new CategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Category entity.
     *
     * @Route("/{id}/update", name="categories_update")
     * @Method("post")
     * @Template("IgaNewsBundle:Category:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('IgaNewsBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm   = $this->createForm(new CategoryType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('categories_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Category entity.
     *
     * @Route("/{id}/delete", name="categories_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();
        
		//TODO: optimize this code
		if($request->isXmlHttpRequest() && $id > 0){
			//avoid csrf validation

            $em = $this->getDoctrine()->getEntityManager();
			$entity = $em->getRepository('IgaNewsBundle:Category')->find($id);
 			
 			if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $em->remove($entity);
            $em->flush();
            
            $response = Array(
            	'success' => true
            );
            return new Response(json_encode($response));
			
		}	

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('IgaNewsBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('categories'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

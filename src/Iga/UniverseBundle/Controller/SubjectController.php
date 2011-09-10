<?php

namespace Iga\UniverseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Iga\UniverseBundle\Entity\Career;
use Iga\UniverseBundle\Form\CareerType;
use Iga\UniverseBundle\Entity\Subject;
use Iga\UniverseBundle\Entity\File;
use Iga\UniverseBundle\Form\SubjectType;
use Iga\UniverseBundle\Form\FileType;

use Iga\UniverseBundle\Util\Slug;


/**
 * Career controller.
 *
 * @Route()
 */
class SubjectController extends Controller
{
    /**
     *
     * @Route("/assignatures", name="assignatures")
     */
    public function assignaturesAction()
    {
		//list careers
        $em = $this->getDoctrine()->getEntityManager();

		//$career = $em->getRepository('IgaUniverseBundle:Career')->findOneBySlug($slug);

		$entities = $em->createQuery('SELECT s FROM IgaUniverseBundle:Subject s')
			->getResult();

        //$entities = $em->getRepository('IgaUniverseBundle:Subject')->findBy(Array('career'=>$career->getId()));
        
        //add subject
        $entity = new Subject();
        //$entity->setCareer($career);
        $form   = $this->createForm(new SubjectType(), $entity);


        return $this->render('IgaUniverseBundle:Subject:assignatures.html.twig',array(
        	'entities' => $entities,
            'entity' => $entity,
            'form'   => $form->createView(),
            'active' => ''
        	));
    }
   
   /**
   * @Route("/{subjectid}", name="followSubject")
   */
   public function followSubjectAction($subjectid){
   	return new Response("null");
   }
    
    /**
     * Creates a new Subject entity.
     *
     * @Route("/{slug}/subjectcreate", name="subject_create")
     * @Method("post")
     */
    public function createAction($slug)
    {
        $entity  = new Subject();
        $request = $this->getRequest();
        $form    = $this->createForm(new SubjectType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            
			$career = $em->getRepository('IgaUniverseBundle:Career')->findOneBySlug($slug);
            
            $entity->setCreatedAt(new \DateTime());
            $entity->setUpdatedAt(new \DateTime());
            $entity->setSlug(new Slug($entity->getName()));
            $entity->setUniversity($career->getUniversity());
            
            $em->persist($entity);
            $em->flush();
			
			$slug = $career->getSlug();

            return $this->redirect($this->generateUrl('career_subjects',array('slug'=>$slug)));
            
        }

        return $this->redirect($this->generateUrl('career_subjects',Array('slug'=>$slug)));


    }

    /**
     * Creates a new File entity.
     *
     * @Route("/{career}/{subject}/sendfile", name="file_create")
     * @Method("post")
     */
    public function sendfileAction($career,$subject)
    {
        $entity  = new File();
        $request = $this->getRequest();
        $form    = $this->createForm(new FileType(), $entity);
        $session = $this->getRequest()->getSession();
		$user = $this->container->get('security.context')->getToken()->getUser();

		if($user){
        if ($this->getRequest()->getMethod() === 'POST') {
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            
			$subject = $em->getRepository('IgaUniverseBundle:Subject')->findOneBySlug($subject);
            
            //$entity->upload();
            $entity->setCreatedAt(new \DateTime());
            $entity->setUpdatedAt(new \DateTime());
            $entity->setSlug(new Slug($entity->getName()));
            $entity->setSubject($subject);
            $entity->setUploader($user);
            
            $file = $em->getRepository('IgaUniverseBundle:File')->findBy(Array('slug'=>$entity->getSlug(),'subject'=>$subject->getId()));
            
            if($file){
            	$session->setFlash('error', "Un archivo con el mismo nombre ya existe en esta asignatura.");
				
				return $this->redirect($this->generateUrl('subject_show',Array('career' => $career, 'subject' => $subject->getSlug())));
            
            }
            
            $em->persist($entity);
            $em->flush();
			//die('object flushed');
            return $this->redirect($this->generateUrl('subject_show',Array('career' => $career, 'subject' => $subject->getSlug())));
            
        }
		}
		}
        return $this->redirect($this->generateUrl('subject_show',Array('career' => $career, 'subject' => $subject)));


    }
    
     /**
     *
     * @Route("/{career}/{subject}", name="subject_show")
     */
    public function subjectShowAction($career,$subject)
    {
    
    	//load context
    	$em = $this->getDoctrine()->getEntityManager();
        
		$career = $em->getRepository('IgaUniverseBundle:Career')->findOneBySlug($career);
		$subject = $em->createQuery('SELECT s FROM IgaUniverseBundle:Subject s WHERE s.career = :career AND s.slug = :slug')
			->setParameter('career',$career->getId())
			->setParameter('slug',$subject)
			->getSingleResult();
			
		//list filetype's
		$fts = $em->getRepository('IgaUniverseBundle:FileType')->findAll();
		
		$entities = Array();
		
		foreach($fts as $filetype){
			$slug = $filetype->getSlug();
			$entities[] = Array(
				'type' => $filetype,
				'entities' => $em->createQuery('SELECT f FROM IgaUniverseBundle:File f WHERE f.subject = :subject AND f.type = :type')
								 ->setParameter('subject',$subject->getId())
								 ->setParameter('type',$filetype->getId())
								 ->getResult()
				);	
		}
		
		//list files
        //$entities = $em->getRepository('IgaUniverseBundle:File')->findBy(Array('subject'=>$subject->getId()));
        
        //add file
        $entity = new File();
        $entity->setSubject($subject);
        $form   = $this->createForm(new FileType(), $entity);

		

        return $this->render('IgaUniverseBundle:Subject:show.html.twig',array(
        	'SortedEntities' => $entities,
            'entity' => $entity,
            'form'   => $form->createView(),
            'active' => Array(
            	'career' => $career->getSlug(),
            	'careerName' => $career->getName(),
            	'subject' => $subject->getSlug(),
            	'subjectName' => $subject->getName()
            	)
            
        	));
    }
    

    
}
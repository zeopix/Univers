<?php

namespace Iga\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;


use Iga\NewsBundle\Entity\Source;
use Iga\NewsBundle\Entity\Item;
use Iga\NewsBundle\Entity\Vendor;
use Iga\NewsBundle\Entity\Category;

use Iga\NewsBundle\Util\Slug;
class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
     public function indexAction(){
     
    	$em = $this->getDoctrine()->getEntityManager();
     	
     	//$items = $em->getRepository('IgaNewsBundle:Item')->findAll();
     	$category = $em->getRepository('IgaNewsBundle:Category')->findOneById(1);
     	
     	$items = $em->createQuery('SELECT i FROM IgaNewsBundle:Item i ORDER BY i.pubDate DESC')->setMaxResults(30)->getResult();
     	
     	return $this->render('IgaNewsBundle:Site:index.html.twig', Array(
     		'items' => $items,
     		'categories' => $category->getChildren(),
     		'active' => Array('1')
     	));
     }  
    /**
     * @Route("/visit/{item}", name="plusOne")
     */
     public function visitItemAction($item){
     
    	$em = $this->getDoctrine()->getEntityManager();
     	
		$item = $em->getRepository('IgaNewsBundle:Item')->findOneById($item);

		$clicks = $item->getClicks();
		$item->setClicks($clicks+1);
		
		$em->persist($item);
		$em->flush($item);
		
		$response = Array(
			'success' => true
		);
		
		return new Response(json_encode($response));

     }
     
    /**
     * @Route("/search", name="search")
     * @Template()
     */
     public function searchAction(){
     
     	$request = $this->getRequest();
     	
     	$q = $request->get('q');
     
    	$em = $this->getDoctrine()->getEntityManager();
     	
     	//$items = $em->getRepository('IgaNewsBundle:Item')->findAll();
     	
     	$items = $em->createQuery('SELECT i FROM IgaNewsBundle:Item i WHERE i.title LIKE :q OR i.description LIKE :q ORDER BY i.pubDate DESC')
     		->setParameter("q","%" . $q . "%")
     		->getResult();
     	
     	return $this->render('IgaNewsBundle:Site:index.html.twig', Array(
     		'items' => $items,
     		'search' => Array(
     			'q' => $q,
     			'results' => count($items)
     		)
     	));
     }
     
     
     
    /**
     * @Route("/{category}", name="category")
     * @Template()
     */
     public function categoryAction($category){
     
    	$em = $this->getDoctrine()->getEntityManager();
     	
     	$category = $em->getRepository('IgaNewsBundle:Category')->findOneBySlug($category);
		$mainCategory = $em->getRepository('IgaNewsBundle:Category')->findOneById(1);

     	$items = $em->createQuery('SELECT i FROM IgaNewsBundle:Item i WHERE i.category = :c ORDER BY i.pubDate DESC')->setParameter('c',$category)->setMaxResults(30)->getResult();
     	
     	$active = Array();
     	$active[] = $category->getId();
     	
     	return $this->render('IgaNewsBundle:Site:index.html.twig', Array(
     		'items' => $items,
     		'categories' => $mainCategory->getChildren(),
     		'active' => $active
     	));
     } 
       
     
    public function crawlAction(){
    
    	$rss = Array();
    	
    	$i = 0;
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	//$sources = $em->getRepository('IgaNewsBundle:Source')->findAll();
    	
		$query = $em->createQuery('SELECT s FROM IgaNewsBundle:Source s ORDER BY s.crawledAt ASC');
		
		$source = $query->getSingleResult();
    	
    	//foreach($sources as $source){
    	
    		$sid = $source->getId();
    		
    		$rss[$sid] = $this->get('iga_rss.rss');
    		
    		$rss[$sid]->load($source->getUrl());
    	
    		$itms = $rss[$sid]->getItems();
    	
    		$lastItem = $itms[0];
    		
			$lastPubDate = \DateTime::createFromFormat(\DateTime::RSS, $lastItem['pubDate']);
			
			$sourceUpdatedDate = $source->getUpdatedAt();

			//die("TS:" . $sourceUpdatedDate->getTimestamp());
			$diff = intval($lastPubDate->getTimestamp()) - intval($sourceUpdatedDate->getTimestamp());
						
    		if($diff < 0){
    	
    		foreach($itms as $item){
    			
    			$i++;
    			    			
    			$slug = new Slug($item['title']);
    			
				$em_item = $em->getRepository('IgaNewsBundle:Ite ')->findOneBySlug($slug);
				if(!$em_item){
    			
    				$items[$i] = new Item();
    				$items[$i]->setTitle($item['title']);
    				$items[$i]->setSlug($slug);
    				$items[$i]->setLink($item['link']);
    			
					$pubDate = \DateTime::createFromFormat(\DateTime::RSS, $item['pubDate']);
				
					$items[$i]->setPubDate($pubDate);
					$items[$i]->setStrPubDate($item['pubDate']);
    				$items[$i]->setLink($item['link']);
    				$items[$i]->setDescription($item['description']);
    				$items[$i]->setSource($source);
    				$items[$i]->setCategory($source->getCategory());
    				$items[$i]->setSlugcategory('prueba');
    			
    				$em->persist($items[$i]);
    			
    			
    				unset($items[$i]);
    			
				}
				
				unset($item);
    			
    		}
    		
    		$source->setUpdatedAt($lastPubDate);
    		    		
    		}
    		
    		//TODO: check that rss was valid
    		$source->setCrawledAt(new \DateTime());
    		
    		$em->persist($source);
    		unset($rss[$sid]);
    		unset($source);
    	
    	//}
    	
    	$em->flush();

		return new Response($i);
    	
    }
}

<?php

namespace Iga\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;


use Iga\NewsBundle\Entity\Source;
use Iga\NewsBundle\Entity\Item;

use Iga\NewsBundle\Util\Slug;


class CrawlController extends Controller
{
    /**
     * @Route("/admin/crawl", name="crawl")
     * @Template()
     */
     public function indexAction(){
     
		$em = $this->getDoctrine()->getEntityManager();

		$sources = $em->getRepository('IgaNewsBundle:Source')->findAll();
		
		return Array('sources'=>$sources , 'vendor' => false);
     
     }

    /**
     * @Route("/admin/vendor/{vendor}", name="crawlVendor")
     */
     public function crawlVendorAction($vendor){
     
		$em = $this->getDoctrine()->getEntityManager();
		
		//$vendor = $em->getRepository('IgaNewsBundle:Vendor')->find($vendor);

		$sources = $em->getRepository('IgaNewsBundle:Source')->findBy(Array('vendor' => $vendor));
		
		return $this->render('IgaNewsBundle:Crawl:index.html.twig',Array('sources'=>$sources, 'vendor' => $vendor));
     
     }
     
     
     
    /**
     * @Route("/admin/crawl/{source}", name="crawlSource")
     * @Template()
     */
    public function crawlSourceAction($source){
    
    	$rss = Array();
    	
    	$i = 0; $j = 0;
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$source = $em->getRepository('IgaNewsBundle:Source')->findOneById($source);
    	
    	$oldcount = $source->getItemsCount();
		//$query = $em->createQuery('SELECT s FROM IgaNewsBundle:Source s ORDER BY s.crawledAt ASC');
		
		//$source = $query->getSingleResult();
    	
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
		
    		if($diff > 0){
    	
    		foreach($itms as $item){
    			
    			$i++;
    			    			
    			$slug = new Slug($item['title']);
    			
				$em_item = $em->getRepository('IgaNewsBundle:Item')->findOneBySlug($slug);
				if(!$em_item){
					$j++;
    			
    				$items[$i] = new Item();
    				$items[$i]->setTitle($item['title']);
    				$items[$i]->setSlug($slug);
    				$items[$i]->setLink($item['link']);
    				$items[$i]->setClicks(1);
    			
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
    		$crawled = new \DateTime();
    		$source->setCrawledAt($crawled);
    		
    		$em->persist($source);
    		unset($rss[$sid]);
    		unset($source);
    	
    	//}
    	
    	$em->flush();

		$count = $oldcount+$j;
		$response = Array(
			'count' => $count,
			'crawled' => $crawled,
			'new' => $j
		);
		return new Response(json_encode($response));
    	
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

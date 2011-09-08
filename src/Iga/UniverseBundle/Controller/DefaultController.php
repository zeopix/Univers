<?php

namespace Iga\UniverseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;

use Iga\UniverseBundle\Util\Slug;


class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
    	$user = $this->container->get('security.context')->getToken()->getUser();
    	
        if (!is_object($user)) {
            return $this->render('IgaUniverseBundle:Public:welcome.html.twig');
        }
		    	
        return $this->redirect($this->generateUrl('career'));
    }
    
    /**
     * @Route("/welcome")
     */
    public function welcomeAction()
    {
    	//welcome/in page?
    	
        return $this->render('IgaUniverseBundle:Public:welcome.html.twig',array(
        	
        ));
    }

    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function demoAction($name)
    {
        return array('name' => $name);
    }

}

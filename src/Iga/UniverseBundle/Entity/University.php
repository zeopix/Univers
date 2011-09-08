<?php

namespace Iga\UniverseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iga\UniverseBundle\Entity\University
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class University
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

	
    /**
     * @ORM\OneToMany(targetEntity="Subject", mappedBy="university")
     */
    private $subjects;
    
    
    /**
     * @ORM\OneToMany(targetEntity="Career", mappedBy="university")
     */
    private $careers;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    
    public function getCareers(){
    	return $this->careers;
    }
    
    public function addCareer($career){
    	$this->careers[] = $career;
    }
    
    
    public function getSubjects(){
    	return $this->subjects;
    }
    
    public function addSubject($subject){
    	$this->subjects[] = $subject;
    }
    
    public function __toString(){
    	return $this->name;
    }
}
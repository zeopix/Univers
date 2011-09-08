<?php

namespace Iga\UniverseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iga\UniverseBundle\Entity\Subject
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Subject
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
     * @var integer $season
     *
     * @ORM\Column(name="season", type="integer")
     */
    private $season;

    /**
     * @var integer $credits
     *
     * @ORM\Column(name="credits", type="integer")
     */
    private $credits;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

	
    
     /**
     * @ORM\ManyToOne(targetEntity="University", inversedBy="subjects")
     * @ORM\JoinColumn(name="university_id", referencedColumnName="id")
     */
    private $university;
    
    
    
     /**
     * @ORM\ManyToOne(targetEntity="Career", inversedBy="subjects")
     * @ORM\JoinColumn(name="career_id", referencedColumnName="id")
     */
    private $career;
    
	/**
     * @ORM\OneToMany(targetEntity="File", mappedBy="subject")
     */
    private $files;
    

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

    /**
     * Set season
     *
     * @param integer $season
     */
    public function setSeason($season)
    {
        $this->season = $season;
    }

    /**
     * Get season
     *
     * @return integer 
     */
    public function getSeason()
    {
        return $this->season;
    }

    /**
     * Set credits
     *
     * @param integer $credits
     */
    public function setCredits($credits)
    {
        $this->credits = $credits;
    }

    /**
     * Get credits
     *
     * @return integer 
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    public function getUniversity(){
    	return $this->university;
    }
    
    public function setUniversity($university){
    	$this->university = $university;
    }
    
    public function getCareer(){
    	return $this->career;
    }
    
    public function setCareer($career){
    	$this->career = $career;
    }
    
    public function getFiles(){
    	return $this->files;
    }
    
}
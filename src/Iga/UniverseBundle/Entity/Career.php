<?php

namespace Iga\UniverseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iga\UniverseBundle\Entity\Career
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Career
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
     * @ORM\Column(name="slug", type="string", length=255, unique="true")
     */
    private $slug;

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
     * @ORM\ManyToOne(targetEntity="University", inversedBy="careers")
     * @ORM\JoinColumn(name="university_id", referencedColumnName="id")
     */
    private $university;
    
     /**
     * @ORM\ManyToOne(targetEntity="Grade", inversedBy="careers")
     * @ORM\JoinColumn(name="grade_id", referencedColumnName="id")
     */
    private $grade;
    
    

    /**
     * @ORM\OneToMany(targetEntity="Subject", mappedBy="career")
     */
    private $subjects;
    
    

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
    
        /**
     * Get crawledAt
     *
     * @return datetime 
     */ 
    
    public function getUniversity(){
    	return $this->university;
    }
    
    public function setUniversity($university){
    	$this->university = $university;
    }
        
    public function getGrade(){
    	return $this->grade;
    }
    
    public function getSubjects(){
    	return $this->subjects;
    }

    
    public function setGrade($grade){
    	$this->grade = $grade;
    }
    
    public function addSubject($subject){
    	$this->subjects[] = $subject;
    }
    
    public function getSubjectCount(){
    	return count($this->subjects);
    }
    
    public function __toString(){
    	return $this->name;
    }
}
<?php

namespace Iga\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iga\NewsBundle\Entity\Source
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Source
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=20, nullable="true")
     */
    private $type;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string $url
     *
     * @ORM\Column(name="publicurl", type="string", length=255, nullable="true")
     */
    private $publicurl;

    /**
     * @var string $url
     *
     * @ORM\Column(name="favicon", type="string", length=255, nullable="true")
     */
    private $favicon;

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
     * @var datetime $crawledAt
     *
     * @ORM\Column(name="crawledAt", type="datetime")
     */
    private $crawledAt;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="sources")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;
    
        /**
     * @ORM\ManyToOne(targetEntity="Vendor", inversedBy="sources")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id")
     */
    private $vendor;
    
    

    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="source")
     */
    private $items;


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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
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
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set url
     *
     * @param string $url
     */
    public function setPublicurl($url)
    {
        $this->publicurl = $url;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getPublicurl()
    {
        return $this->publicurl;
    }

    /**
     * Set url
     *
     * @param string $url
     */
    public function setFavicon($url)
    {
        $this->favicon = $url;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getFavicon()
    {
        return $this->favicon;
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
     * Set crawledAt
     *
     * @param datetime $crawledAt
     */
    public function setCrawledAt($crawledAt)
    {
        $this->crawledAt = $crawledAt;
    }

    /**
     * Get crawledAt
     *
     * @return datetime 
     */
    public function getCrawledAt()
    {
        return $this->crawledAt;
    }
    
    public function getCategory(){
    	return $this->category;
    }
    
    public function setCategory($category){
    	$this->category = $category;
    }
    
    public function getVendor(){
    	return $this->vendor;
    }
    
    public function setVendor($vendor){
    	$this->vendor = $vendor;
    }
    
    public function getItemsCount(){
    	return count($this->items);
    }
}
<?php

namespace Iga\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Iga\NewsBundle\Entity\Item
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Item
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
     * @var integer $id
     *
     * @ORM\Column(name="clicks", type="integer")
     */
    private $clicks;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string $link
     *
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;

    /**
     * @var datetime $pubDate
     *
     * @ORM\Column(name="pubDate", type="datetime")
     */
    private $pubDate;

    /**
     * @var datetime $strPubDate
     *
     * @ORM\Column(name="strPubDate", type="string", length=80)
     */
    private $strPubDate;

    /**
     * @var text $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string $slugcategory
     *
     * @ORM\Column(name="slugcategory", type="string", length=50)
     */
    private $slugcategory;

    /**
     * @ORM\ManyToOne(targetEntity="Source", inversedBy="items")
     * @ORM\JoinColumn(name="source_id", referencedColumnName="id")
     */
    private $source;
    
        /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="items")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

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
     * Set link
     *
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set pubDate
     *
     * @param datetime $pubDate
     */
    public function setPubDate($pubDate)
    {
        $this->pubDate = $pubDate;
    }

    /**
     * Get pubDate
     *
     * @return datetime 
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * Set pubDate
     *
     * @param datetime $pubDate
     */
    public function setStrPubDate($pubDate)
    {
        $this->strPubDate = $pubDate;
    }

    /**
     * Get pubDate
     *
     * @return datetime 
     */
    public function getStrPubDate()
    {
        return $this->strPubDate;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription($chars = 0)
    {
    	return ($chars > 0) ? substr($this->description,0,$chars) : $this->description;
    }

    /**
     * Get description
     *
     * @return text 
     */

    /**
     * Set slugcategory
     *
     * @param string $slugcategory
     */
    public function setSlugcategory($slugcategory)
    {
        $this->slugcategory = $slugcategory;
    }

    /**
     * Get slugcategory
     *
     * @return string 
     */
    public function getSlugcategory()
    {
        return $this->slugcategory;
    }
    
    
    
    public function getCategory(){
    	return $this->category;
    }
    
    public function setCategory($category){
    	$this->category = $category;
    }
    
    
    
    public function getSource(){
    	return $this->source;
    }
    
    public function setSource($source){
    	$this->source = $source;
    }
    
    public function setClicks($clicks){
    	$this->clicks = $clicks;
    }
    
    public function getClicks(){
    	return $this->clicks;
    }
}
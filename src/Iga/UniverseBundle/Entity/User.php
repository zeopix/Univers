<?php
namespace Iga\UniverseBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


	/**
     * @ORM\OneToMany(targetEntity="File", mappedBy="uploader")
     */
    private $files;
    
    
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
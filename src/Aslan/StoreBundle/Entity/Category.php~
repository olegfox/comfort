<?php 
namespace Aslan\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Aslan\StoreBundle\Translitor\Translitor;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $img;       
    
    /**
     * @ORM\Column(type="text")
     */
    protected $name;  
    
    /**
     * @ORM\Column(type="text")
     */
    protected $slug;          

    /**
     * @ORM\Column(type="text")
     */
    protected $color;          
    
    /**
     * @ORM\OneToMany(targetEntity="Afisha", cascade={"remove"}, mappedBy="category")
     */    
    protected $afisha;     
    
    public function __construct()
    {
        $this->afisha = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set img
     *
     * @param text $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * Get img
     *
     * @return text 
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set name
     *
     * @param text $name
     */
    public function setName($name)
    {
        $tr = new Translitor();
        $slug = $tr->translitIt($name);
        $this->setSlug($slug);        
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return text 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param text $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return text 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add afisha
     *
     * @param Aslan\StoreBundle\Entity\Afisha $afisha
     */
    public function addAfisha(\Aslan\StoreBundle\Entity\Afisha $afisha)
    {
        $this->afisha[] = $afisha;
    }

    /**
     * Get afisha
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAfisha()
    {
        return $this->afisha;
    }

    /**
     * Set color
     *
     * @param text $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * Get color
     *
     * @return text 
     */
    public function getColor()
    {
        return $this->color;
    }
}
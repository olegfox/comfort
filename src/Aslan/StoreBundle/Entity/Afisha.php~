<?php 
namespace Aslan\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Aslan\StoreBundle\Translitor\Translitor;

/**
 * @ORM\Entity
 * @ORM\Table(name="afisha")
 */
class Afisha
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
    protected $date;        
    
    /**
     * @ORM\ManyToOne(targetEntity="News", inversedBy="afisha")
     * @ORM\JoinColumn(name="place_id",  referencedColumnName="id")
     */
    protected $place; 

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="afisha")
     * @ORM\JoinColumn(name="category_id",  referencedColumnName="id")
     */
    protected $category; 

    /**
     * @ORM\Column(type="text")
     */
    protected $text;  
    
    /**
     * @ORM\Column(type="text")
     */
    protected $color;    
    
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
     * Set date
     *
     * @param text $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get date
     *
     * @return text 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set place
     *
     * @param Aslan\StoreBundle\Entity\News $place
     */
    public function setPlace(\Aslan\StoreBundle\Entity\News $place)
    {
        $this->place = $place;
    }

    /**
     * Get place
     *
     * @return Aslan\StoreBundle\Entity\News 
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set category
     *
     * @param Aslan\StoreBundle\Entity\Category $category
     */
    public function setCategory(\Aslan\StoreBundle\Entity\Category $category)
    {
        $this->category = $category;
    }

    /**
     * Get category
     *
     * @return Aslan\StoreBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set text
     *
     * @param text $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Get text
     *
     * @return text 
     */
    public function getText()
    {
        return $this->text;
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
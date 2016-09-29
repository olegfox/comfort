<?php 
namespace Aslan\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Aslan\StoreBundle\Translitor\Translitor;

/**
 * @ORM\Entity
 * @ORM\Table(name="place")
 */
class News
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
    protected $head;    
    
    /**
     * @ORM\Column(type="text")
     */
    protected $slug;        
    
    /**
     * @ORM\Column(type="text")
     */
    protected $page;    

    /**
     * @ORM\OneToMany(targetEntity="ImgPage", cascade={"remove"}, mappedBy="page")
     */    
    protected $pageimgs;       
    
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
     * Set head
     *
     * @param text $head
     */
    public function setHead($head)
    {
        $tr = new Translitor();
        $slug = $tr->translitIt($head);
        $this->setSlug($slug);        
        $this->head = $head;
    }

    /**
     * Get head
     *
     * @return text 
     */
    public function getHead()
    {
        return $this->head;
    }    

    /**
     * Set page
     *
     * @param text $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * Get page
     *
     * @return text 
     */
    public function getPage()
    {
        return $this->page;
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
    public function __construct()
    {
        $this->pageimgs = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add pageimgs
     *
     * @param Aslan\StoreBundle\Entity\ImgPage $pageimgs
     */
    public function addImgPage(\Aslan\StoreBundle\Entity\ImgPage $pageimgs)
    {
        $this->pageimgs[] = $pageimgs;
    }

    /**
     * Get pageimgs
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getPageimgs()
    {
        return $this->pageimgs;
    }
}
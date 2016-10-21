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
     * @ORM\Column(type="text", nullable=true)
     */
    protected $head;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=512, nullable=true)
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string", length=500, nullable=true)
     */
    private $metaDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_keywords", type="string", length=500, nullable=true)
     */
    private $metaKeywords;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $page;    

    /**
     * @ORM\OneToMany(targetEntity="ImgPage", cascade={"remove"}, mappedBy="page")
     */    
    protected $pageimgs;

    /**
     * @ORM\ManyToOne(targetEntity="News", inversedBy="shildren")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     **/
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="News", mappedBy="parent", cascade={"persist", "remove"})
     **/
    private $children;
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId()
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

    /**
     * Set metaTitle
     *
     * @param string $metaTitle
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;
    }

    /**
     * Get metaTitle
     *
     * @return string 
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }

    /**
     * Get metaDescription
     *
     * @return string 
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set metaKeywords
     *
     * @param string $metaKeywords
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
    }

    /**
     * Get metaKeywords
     *
     * @return string 
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * Set parent
     *
     * @param Aslan\StoreBundle\Entity\News $parent
     */
    public function setParent(\Aslan\StoreBundle\Entity\News $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return Aslan\StoreBundle\Entity\News 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param Aslan\StoreBundle\Entity\News $children
     */
    public function addNews(\Aslan\StoreBundle\Entity\News $children)
    {
        $this->children[] = $children;
    }

    /**
     * Get children
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    public function __toString() {
        return $this->head;
    }

    public function getJson() {
        return json_encode(array(
            'id' => $this->id,
            'head' => $this->head,
            'slug' => $this->slug,
            'metaTitle' => $this->metaTitle,
            'metaDescription' => $this->metaDescription,
            'metaKeywords' => $this->metaKeywords,
            'page' => $this->page,
            'parentId' => is_object($this->getParent()) ? $this->getParent()->getId() : null
        ));
    }

    public function getPreview() {
        return isset($this->getPageimgs()[0]) ? $this->getPageimgs()[0] : false;
    }
}
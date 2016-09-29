<?php 
namespace Aslan\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="placeslider")
 */
class ImgPage
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
     * @ORM\ManyToOne(targetEntity="News", inversedBy="pageimgs")
     * @ORM\JoinColumn(name="idpage",  referencedColumnName="id")
     */
    protected $page;      

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
     * Set page
     *
     * @param Aslan\StoreBundle\Entity\News $page
     */
    public function setPage(\Aslan\StoreBundle\Entity\News $page)
    {
        $this->page = $page;
    }

    /**
     * Get page
     *
     * @return Aslan\StoreBundle\Entity\News 
     */
    public function getPage()
    {
        return $this->page;
    }
}
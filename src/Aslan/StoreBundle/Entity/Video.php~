<?php 
namespace Aslan\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="video")
 */
class Video
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
    protected $code;  

    /**
     * @ORM\Column(type="text")
     */
    protected $img;      
    
    /**
     * @ORM\Column(type="text")
     */
    protected $head;      
    
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
     * Set src
     *
     * @param text $src
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * Get src
     *
     * @return text 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set head
     *
     * @param text $head
     */
    public function setHead($head)
    {
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
}
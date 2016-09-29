<?php 
namespace Aslan\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="image")
 */
class Image
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
    protected $src;  
    
    /**
     * @ORM\ManyToOne(targetEntity="Albums", inversedBy="images")
     * @ORM\JoinColumn(name="albums_id", referencedColumnName="id")
     */
    protected $albums;    
    

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
    public function setSrc($src)
    {
        $this->src = $src;
    }

    /**
     * Get src
     *
     * @return text 
     */
    public function getSrc()
    {
        return $this->src;
    }
    
    /**
     * Set albums
     *
     * @param Aslan\StoreBundle\Entity\Albums $albums
     */
    public function setAlbums(\Aslan\StoreBundle\Entity\Albums $albums=null)
    {
        $this->albums = $albums;
    }

    /**
     * Get albums
     *
     * @return Aslan\StoreBundle\Entity\Albums 
     */
    public function getAlbums()
    {
        return $this->albums;
    }      
}
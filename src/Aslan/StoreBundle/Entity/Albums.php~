<?php

namespace Aslan\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Aslan\StoreBundle\Translitor\Translitor;

/**
 * @ORM\Entity
 * @ORM\Table(name="albums")
 */
class Albums {

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
     * @ORM\Column(type="text")
     */
    protected $slug;

    /**
     * @ORM\Column(type="text")
     */
    protected $name;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $color;    

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $time;

    /**
     * @ORM\OneToMany(targetEntity="Image", cascade={"remove"},  mappedBy="albums")
     */
    protected $images;

    /**
     * @ORM\ManyToOne(targetEntity="News", inversedBy="albums")
     * @ORM\JoinColumn(name="place_id",  referencedColumnName="id")
     */
    protected $place;     
    
    public function __construct() {
        $this->images = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set src
     *
     * @param text $src
     */
    public function setSrc($src) {
        $this->src = $src;
    }

    /**
     * Get src
     *
     * @return text 
     */
    public function getSrc() {
        return $this->src;
    }

    /**
     * Set name
     *
     * @param text $name
     */
    public function setName($name) {
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
    public function getName() {
        return $this->name;
    }

    /**
     * Add images
     *
     * @param Aslan\StoreBundle\Entity\Image $images
     */
    public function addImage(\Aslan\StoreBundle\Entity\Image $images) {
        $this->images[] = $images;
    }

    /**
     * Get images
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getImages() {
        return $this->images;
    }

    /**
     * Set time
     *
     * @param integer $time
     */
    public function setTime($time) {
        $this->time = $time;
    }

    /**
     * Get time
     *
     * @return integer 
     */
    public function getTime() {
        return $this->time;
    }

    /**
     * Set slug
     *
     * @param text $slug
     */
    public function setSlug($slug) {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return text 
     */
    public function getSlug() {
        return $this->slug;
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
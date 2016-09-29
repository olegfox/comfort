<?php

// src/Acme/AdminBundle/Entity/Page.php

namespace Aslan\AdminBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;

class Pages {

    /**
     * @Assert\NotBlank()
     */
    protected $id;
    protected $name;
    protected $img;
    protected $time;
    protected $place;

    public function getTime() {
        return $this->time;
    }

    public function setTime($time) {
        $this->time = $time;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getImg() {
        return $this->img;
    }

    public function setImg($img) {
        $this->img = $img;
    }
    
    public function getPlace() {
        return $this->place;
    }

    public function setPlace($place) {
        $this->place = $place;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        $metadata->addPropertyConstraint('name', new NotBlank());
        //$metadata->addPropertyConstraint('img', new NotBlank('/File'));
        //$metadata->addPropertyConstraint('brand', new NotBlank('/Choice'));
    }

}

?>

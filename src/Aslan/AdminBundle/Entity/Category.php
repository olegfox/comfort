<?php
// src/Acme/AdminBundle/Entity/Page.php
namespace Aslan\AdminBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;



class Category {
	/**
	 * @Assert\NotBlank()
	 */
        protected $name;
        protected $img;        
	protected $id;        
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
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}					
	public static function loadValidatorMetadata(ClassMetadata $metadata) {
		//$metadata->addPropertyConstraint('img', new NotBlank('/File'));
		//$metadata->addPropertyConstraint('img', new NotBlank('/File'));
		//$metadata->addPropertyConstraint('brand', new NotBlank('/Choice'));
	}
}
?>

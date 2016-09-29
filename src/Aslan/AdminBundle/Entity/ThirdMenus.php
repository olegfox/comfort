<?php
// src/Acme/AdminBundle/Entity/Page.php
namespace Aslan\AdminBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;



class ThirdMenus {
	/**
	 * @Assert\NotBlank()
	 */
	protected $id;
	protected $name;
	protected $text;
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
	public function getText() {
		return $this->text;
	}
	public function setText($text) {
		$this->text = $text;
	}		
	public static function loadValidatorMetadata(ClassMetadata $metadata) {
		$metadata->addPropertyConstraint('name', new NotBlank());
		//$metadata->addPropertyConstraint('img', new NotBlank('/File'));
		//$metadata->addPropertyConstraint('brand', new NotBlank('/Choice'));
	}
}
?>

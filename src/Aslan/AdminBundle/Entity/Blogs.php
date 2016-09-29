<?php
// src/Acme/AdminBundle/Entity/Page.php
namespace Aslan\AdminBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;



class Blogs {
	/**
	 * @Assert\NotBlank()
	 */
        protected $date;
        protected $name;
        protected $text;         
	protected $id;
	public function getDate() {
		return $this->date;
	}
	public function setDate($date) {
		$this->date = $date;
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

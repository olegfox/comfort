<?php
// src/Acme/AdminBundle/Entity/Page.php
namespace Aslan\AdminBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;



class Brands {
	/**
	 * @Assert\NotBlank()
	 */
	protected $name;
	protected $time;
        protected $nameEn;
        protected $nameDe;
	protected $id;
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
	}
        public function getNameEn() {
		return $this->nameEn;
	}
	public function setNameEn($nameEn) {
		$this->nameEn = $nameEn;
	}
        public function getNameDe() {
		return $this->nameDe;
	}
	public function setNameDe($nameDe) {
		$this->nameDe = $nameDe;
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

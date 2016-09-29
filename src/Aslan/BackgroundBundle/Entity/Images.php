<?php
// src/Acme/AdminBundle/Entity/Page.php
namespace Aslan\BackgroundBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;



class Images {
	/**
	 * @Assert\NotBlank()
	 */
	protected $img;
	public function getImg() {
		return $this->img;
	}
	public function setImg($img) {
		$this->img = $img;
	}				
	public static function loadValidatorMetadata(ClassMetadata $metadata) {
		//$metadata->addPropertyConstraint('img', new NotBlank('/File'));
		//$metadata->addPropertyConstraint('img', new NotBlank('/File'));
		//$metadata->addPropertyConstraint('brand', new NotBlank('/Choice'));
	}
}
?>

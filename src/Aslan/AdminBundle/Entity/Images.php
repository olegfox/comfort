<?php
// src/Acme/AdminBundle/Entity/Page.php
namespace Aslan\AdminBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;



class Images {
	/**
	 * @Assert\NotBlank()
	 */
	protected $src;
	protected $href;
	public function getSrc() {
		return $this->src;
	}
	public function setSrc($src) {
		$this->src = $src;
	}
	public function getHref() {
		return $this->href;
	}
	public function setHref($href) {
		$this->href = $href;
	}								
	public static function loadValidatorMetadata(ClassMetadata $metadata) {
		//$metadata->addPropertyConstraint('img', new NotBlank('/File'));
		//$metadata->addPropertyConstraint('img', new NotBlank('/File'));
		//$metadata->addPropertyConstraint('brand', new NotBlank('/Choice'));
	}
}
?>

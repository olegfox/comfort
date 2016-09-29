<?php
// src/Acme/PageBundle/Entity/Email.php
namespace Aslan\PageBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;



class Email {
	/**
	 * @Assert\NotBlank()
	 */
	protected $email;
	public function getEmail() {
		return $this->email;
	}
	public function setEmail($email) {
		$this->email = $email;
	}
	public static function loadValidatorMetadata(ClassMetadata $metadata) {
		$metadata->addPropertyConstraint('email', new NotBlank());
	}
}
?>

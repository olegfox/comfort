<?php
// src/Aslan/PageBundle/Form/Type/EmailType.php
namespace Aslan\PageBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
class EmailType extends AbstractType {
	public function buildForm(FormBuilder $builder, array $options) {
		$builder->add('email', 'email');
	}
	public function getName() {
		return 'emails';
	}
}

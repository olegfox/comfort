<?php
// src/Aslan/AdminBundle/Form/Type/PageType.php
namespace Aslan\AdminBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
class ThirdMenuType extends AbstractType {
	public function buildForm(FormBuilder $builder, array $options) {
		$builder->add('id', 'text');
		$builder->add('name', 'text');
		$builder->add('text', 'textarea');
	}
	public function __construct(){
	}
	public function getName() {
		return 'names';
	}
	public function getText() {
		return 'texts';
	}	
}

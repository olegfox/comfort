<?php
// src/Aslan/AdminBundle/Form/Type/PageType.php
namespace Aslan\AdminBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
class ImageType extends AbstractType {
	public function buildForm(FormBuilder $builder, array $options) {
		$builder->add('src', 'file');
		$builder->add('href', 'url');
	}
	public function getName() {
		return 'names';
	}	
}

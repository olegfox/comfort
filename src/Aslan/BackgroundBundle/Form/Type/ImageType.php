<?php
// src/Aslan/AdminBundle/Form/Type/PageType.php
namespace Aslan\BackgroundBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
class ImageType extends AbstractType {
	public function buildForm(FormBuilder $builder, array $options) {
		$builder->add('img', 'file');
	}
	public function getName() {
		return 'names';
	}
	public function getImg() {
		return 'imgs';
	}	
}

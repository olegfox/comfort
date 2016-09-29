<?php
// src/Aslan/AdminBundle/Form/Type/PageType.php
namespace Aslan\AdminBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
class BrandType extends AbstractType {
	public function buildForm(FormBuilder $builder, array $options) {
		$builder->add('name', 'text');
		$builder->add('nameEn', 'text');
                $builder->add('nameDe', 'text');
                $builder->add('id', 'text');
	}
	public function getName() {
		return 'names';
	}
}

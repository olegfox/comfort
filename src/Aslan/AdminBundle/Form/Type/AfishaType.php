<?php

// src/Aslan/AdminBundle/Form/Type/PageType.php

namespace Aslan\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Aslan\AdminBundle\Color\Color;

class AfishaType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $colors = new Color();
        $builder->add('id', 'text');
        $builder->add('name', 'text');
        $builder->add('img', 'file');
        $builder->add('time', 'date', array(
            'input' => 'timestamp',
            'widget' => 'choice',
            'data' => time()
        ));
        $builder->add('color', 'choice', array("choices" => $colors->colors()));
        $builder->add('place', 'choice', array("choices" => $this->brandall));
        $builder->add('category', 'choice', array("choices" => $this->catall));
        $builder->add('text', 'textarea');
    }

    public function __construct($brandall, $catall) {
        $brands = array();
        foreach ($brandall as $value) {
            $brands[$value->getId()] = $value->getHead();
        }
        $this->brandall = $brands;

        $cats = array();
        foreach ($catall as $value) {
            $cats[$value->getId()] = $value->getName();
        }
        $this->catall = $cats;
    }

    public function getName() {
        return 'names';
    }

}

<?php

// src/Aslan/AdminBundle/Form/Type/PageType.php

namespace Aslan\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PageType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('id', 'text');
        $builder->add('name', 'text');
        $builder->add('img', 'file');
        $builder->add('time', 'date', array(
            'input' => 'timestamp',
            'widget' => 'choice',
            'data' => time()
        ));
        $builder->add('place', 'choice', array("choices" => $this->brandall));
    }

    public function __construct($brandall) {
        $i = 0;
        $brands = array();
        foreach ($brandall as $value) {
            $brands[$value->getId()] = $value->getHead();
        }
        $this->brandall = $brands;
    }

    public function getName() {
        return 'names';
    }

}

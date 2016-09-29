<?php

// src/Aslan/AdminBundle/Form/Type/PageType.php

namespace Aslan\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class BlogsType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('text', 'textarea');
        $builder->add('name', 'textarea');     
        $builder->add('id', 'text');
    }  
    
    public function getName() {
        return 'names';
    }  

}

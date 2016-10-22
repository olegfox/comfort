<?php

// src/Aslan/AdminBundle/Form/Type/PageType.php

namespace Aslan\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;


class BlogsType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options) {
        $builder->add('parent', 'entity', array(
            'required' => false,
            'class' => 'Aslan\StoreBundle\Entity\News',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('n')
                    ->where('n.head != :head')
                    ->andWhere('n.parent IS NULL')
                    ->setParameter('head', '&nbsp;');
            }
        ));
        $builder->add('special', 'choice', array(
            "choices" => array(
                0 => 'Нет',
                1 => 'Да'
            )
        ));
        $builder->add('meta_title', null, array(
            'required' => false
        ));
        $builder->add('meta_description', null, array(
            'required' => false
        ));
        $builder->add('meta_keywords', 'textarea', array(
            'required' => false
        ));
        $builder->add('page', 'textarea');
        $builder->add('head', 'text');
        $builder->add('id', 'text');
    }  
    
    public function getName() {
        return 'names';
    }  

}

<?php

namespace Iga\NewsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('path','text',Array('required'=>false))
            ->add('shortdesc','text',Array('required'=>false))
            ->add('description','textarea',Array('required'=>false))
            ->add('parent')
        ;
    }

    public function getName()
    {
        return 'iga_newsbundle_categorytype';
    }
}

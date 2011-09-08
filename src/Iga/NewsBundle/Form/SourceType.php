<?php

namespace Iga\NewsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SourceType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('url')
            ->add('publicurl','text',Array('required'=>false))
            ->add('category')
            ->add('vendor')
        ;
    }

    public function getName()
    {
        return 'iga_newsbundle_sourcetype';
    }
}

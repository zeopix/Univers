<?php

namespace Iga\NewsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class VendorType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('url')
            ->add('favicon')
            ->add('logo')
        ;
    }

    public function getName()
    {
        return 'iga_newsbundle_vendortype';
    }
}

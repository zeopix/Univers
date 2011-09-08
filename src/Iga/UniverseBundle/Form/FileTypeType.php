<?php

namespace Iga\UniverseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FileTypeType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug')
        ;
    }

    public function getName()
    {
        return 'iga_universebundle_filetypetype';
    }
}

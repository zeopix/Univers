<?php

namespace Iga\UniverseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class FileType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('type')
            ->add('file','file')
        ;
    }

    public function getName()
    {
        return 'iga_universebundle_filetype';
    }
}

<?php

namespace Iga\UniverseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SubjectType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('season','text')
            ->add('name')
            ->add('credits','text')
            ->add('career')
        ;
    }

    public function getName()
    {
        return 'iga_universebundle_subjecttype';
    }
}

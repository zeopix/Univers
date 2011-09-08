<?php

namespace Iga\UniverseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class CareerType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('university')
            ->add('grade')
        ;
    }

    public function getName()
    {
        return 'iga_universebundle_careertype';
    }
}

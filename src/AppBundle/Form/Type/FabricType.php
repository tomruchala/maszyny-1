<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class FabricType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', 'text', array('label' => 'Nazwa'))
                ->add('code', 'text', array('label' => 'Kod'))
                ->add('quantity', 'text', array('label' => 'Stan magazynowy'));                
    }

    public function getName()
    {
        return 'fabric';
    }
}
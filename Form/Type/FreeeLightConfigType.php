<?php

namespace Plugin\FreeeLight\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class FreeeLightConfigType extends AbstractType
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('client_id', 'text', array(
                'constraints' => array(
                    new Assert\NotBlank(),
                ),
            ))
            ->add('client_secret', 'text', array(
                'constraints' => array(
                    new Assert\NotBlank(),
                ),
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Plugin\FreeeLight\Entity\FreeeLight',
        ));
    }

    public function getName()
    {
        return 'freeelight_config';
    }
}

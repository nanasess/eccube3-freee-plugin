<?php

namespace Plugin\FreeeLight\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class FreeeLightConfig2Type extends AbstractType
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('company_id', 'freee_company');

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Plugin\FreeeLight\Entity\FreeeLight',
        ));
    }

    public function getName()
    {
        return 'freeelight_config2';
    }
}

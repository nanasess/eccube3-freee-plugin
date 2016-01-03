<?php

namespace Plugin\FreeeLight\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FreeeCompanyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'multiple'=> false,
            'expanded' => false,
            'required' => true,
            'class' => 'Plugin\FreeeLight\Entity\FreeeCompany',
            'empty_value' => '企業を選択してください',
            'property' => 'display_name'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'entity';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'freee_company';
    }
}

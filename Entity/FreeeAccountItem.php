<?php

namespace Plugin\FreeeLight\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FreeeAccountItem
 */
class FreeeAccountItem extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $shortcut;

    /**
     * @var integer
     */
    private $default_tax_id;

    /**
     * @var integer
     */
    private $default_tax_code;


    /**
     * Set id
     *
     * @param integer $id
     * @return FreeeAccountItem
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return FreeeAccountItem
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set shortcut
     *
     * @param string $shortcut
     * @return FreeeAccountItem
     */
    public function setShortcut($shortcut)
    {
        $this->shortcut = $shortcut;

        return $this;
    }

    /**
     * Get shortcut
     *
     * @return string
     */
    public function getShortcut()
    {
        return $this->shortcut;
    }

    /**
     * Set default_tax_id
     *
     * @param integer $defaultTaxId
     * @return FreeeAccountItem
     */
    public function setDefaultTaxId($defaultTaxId)
    {
        $this->default_tax_id = $defaultTaxId;

        return $this;
    }

    /**
     * Get default_tax_id
     *
     * @return integer
     */
    public function getDefaultTaxId()
    {
        return $this->default_tax_id;
    }

    /**
     * Set default_tax_code
     *
     * @param integer $defaultTaxCode
     * @return FreeeAccountItem
     */
    public function setDefaultTaxCode($defaultTaxCode)
    {
        $this->default_tax_code = $defaultTaxCode;

        return $this;
    }

    /**
     * Get default_tax_code
     *
     * @return integer
     */
    public function getDefaultTaxCode()
    {
        return $this->default_tax_code;
    }
}

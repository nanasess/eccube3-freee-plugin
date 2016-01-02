<?php

namespace Plugin\FreeeLight\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FreeeTax
 */
class FreeeTax extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var integer
     */
    private $code;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $name_ja;


    /**
     * Set code
     *
     * @param integer $code
     * @return FreeeTax
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return FreeeTax
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
     * Set name_ja
     *
     * @param string $nameJa
     * @return FreeeTax
     */
    public function setNameJa($nameJa)
    {
        $this->name_ja = $nameJa;

        return $this;
    }

    /**
     * Get name_ja
     *
     * @return string
     */
    public function getNameJa()
    {
        return $this->name_ja;
    }
}

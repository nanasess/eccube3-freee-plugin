<?php

namespace Plugin\FreeeLight\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FreeeWallet
 */
class FreeeWallet extends \Eccube\Entity\AbstractEntity
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
     * @var integer
     */
    private $bank_id;

    /**
     * @var string
     */
    private $type;


    /**
     * Set id
     *
     * @param integer $id
     * @return FreeeWallet
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
     * @return FreeeWallet
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
     * Set bank_id
     *
     * @param integer $bankId
     * @return FreeeWallet
     */
    public function setBankId($bankId)
    {
        $this->bank_id = $bankId;

        return $this;
    }

    /**
     * Get bank_id
     *
     * @return integer
     */
    public function getBankId()
    {
        return $this->bank_id;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return FreeeWallet
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}

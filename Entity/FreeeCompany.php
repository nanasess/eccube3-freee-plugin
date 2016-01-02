<?php

namespace Plugin\FreeeLight\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FreeeCompany
 */
class FreeeCompany extends \Eccube\Entity\AbstractEntity
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
    private $name_kana;

    /**
     * @var string
     */
    private $display_name;

    /**
     * @var string
     */
    private $role;


    /**
     * Set id
     *
     * @param integer $id
     * @return FreeeCompany
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
     * @return FreeeCompany
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
     * Set name_kana
     *
     * @param string $nameKana
     * @return FreeeCompany
     */
    public function setNameKana($nameKana)
    {
        $this->name_kana = $nameKana;

        return $this;
    }

    /**
     * Get name_kana
     *
     * @return string
     */
    public function getNameKana()
    {
        return $this->name_kana;
    }

    /**
     * Set display_name
     *
     * @param string $displayName
     * @return FreeeCompany
     */
    public function setDisplayName($displayName)
    {
        $this->display_name = $displayName;

        return $this;
    }

    /**
     * Get display_name
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * Set role
     *
     * @param string $role
     * @return FreeeCompany
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }
}

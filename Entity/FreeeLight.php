<?php

namespace Plugin\FreeeLight\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FreeeLight
 */
class FreeeLight extends \Eccube\Entity\AbstractEntity
{
    private $id;
    private $api_user;
    private $api_key;

    /**
     * Set id
     *
     * @param integer $id
     * @return FreeeLight
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
     * Set api_user
     *
     * @param string $apiUser
     * @return FreeeLight
     */
    public function setApiUser($apiUser)
    {
        $this->api_user = $apiUser;

        return $this;
    }

    /**
     * Get api_user
     *
     * @return string
     */
    public function getApiUser()
    {
        return $this->api_user;
    }

    /**
     * Set api_key
     *
     * @param string $apiKey
     * @return FreeeLight
     */
    public function setApiKey($apiKey)
    {
        $this->api_key = $apiKey;

        return $this;
    }

    /**
     * Get api_password
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->api_key;
    }

}

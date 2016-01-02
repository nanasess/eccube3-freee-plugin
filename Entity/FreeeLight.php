<?php

namespace Plugin\FreeeLight\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FreeeLight
 */
class FreeeLight extends \Eccube\Entity\AbstractEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $client_id;

    /**
     * @var string
     */
    private $client_secret;

    /**
     * @var integer
     */
    private $company_id;


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
     * Set client_id
     *
     * @param string $clientId
     * @return FreeeLight
     */
    public function setClientId($clientId)
    {
        $this->client_id = $clientId;

        return $this;
    }

    /**
     * Get client_id
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Set client_secret
     *
     * @param string $clientSecret
     * @return FreeeLight
     */
    public function setClientSecret($clientSecret)
    {
        $this->client_secret = $clientSecret;

        return $this;
    }

    /**
     * Get client_secret
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * Set company_id
     *
     * @param integer $companyId
     * @return FreeeLight
     */
    public function setCompanyId($companyId)
    {
        $this->company_id = $companyId;

        return $this;
    }

    /**
     * Get company_id
     *
     * @return integer
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }
}

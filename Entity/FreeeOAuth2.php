<?php

namespace Plugin\FreeeLight\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FreeeOAuth2
 */
class FreeeOAuth2 extends \Eccube\Entity\AbstractEntity
{
    const DEFAULT_ID = 1;
    const API_HOST = 'https://api.freee.co.jp';
    const TOKEN_ROUTE = '/oauth/token';
    const AUTHORIZE_ROUTE = 'https://secure.freee.co.jp/oauth/authorize';
    const RESOURCE_ROUTE = '/oauth/token?grant_type=refresh_token';
    const RESOURCE_METHOD = 'POST';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $access_token;

    /**
     * @var string
     */
    private $token_type;

    /**
     * @var integer
     */
    private $expires_in;

    /**
     * @var string
     */
    private $refresh_token;

    /**
     * @var string
     */
    private $scope;

    /**
     * @var \DateTime
     */
    private $update_date;

    /**
     * Set id
     *
     * @param integer $id
     * @return FreeeOAuth2
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
     * Set access_token
     *
     * @param string $accessToken
     * @return FreeeOAuth2
     */
    public function setAccessToken($accessToken)
    {
        $this->access_token = $accessToken;

        return $this;
    }

    /**
     * Get access_token
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * Set token_type
     *
     * @param string $tokenType
     * @return FreeeOAuth2
     */
    public function setTokenType($tokenType)
    {
        $this->token_type = $tokenType;

        return $this;
    }

    /**
     * Get token_type
     *
     * @return string
     */
    public function getTokenType()
    {
        return $this->token_type;
    }

    /**
     * Set expires_in
     *
     * @param integer $expiresIn
     * @return FreeeOAuth2
     */
    public function setExpiresIn($expiresIn)
    {
        $this->expires_in = $expiresIn;

        return $this;
    }

    /**
     * Get expires_in
     *
     * @return integer
     */
    public function getExpiresIn()
    {
        return $this->expires_in;
    }

    /**
     * Set refresh_token
     *
     * @param string $refreshToken
     * @return FreeeOAuth2
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refresh_token = $refreshToken;

        return $this;
    }

    /**
     * Get refresh_token
     *
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refresh_token;
    }

    /**
     * Set scope
     *
     * @param string $scope
     * @return FreeeOAuth2
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope
     *
     * @return string
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set update_date
     *
     * @param  \DateTime $updateDate
     * @return Customer
     */
    public function setUpdateDate($updateDate)
    {
        $this->update_date = $updateDate;

        return $this;
    }

    /**
     * Get update_date
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }

    public function getExpireTime()
    {
        if ($this->getUpdateDate()) {
            return $this->getUpdateDate()->getTimestamp() + $this->getExpiresIn();
        }
        return 0;
    }

    public function isExpire()
    {
        return $this->getExpireTime() <= time();
    }
}

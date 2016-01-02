<?php

namespace Plugin\FreeeLight\Controller;

use Eccube\Application;
use Eccube\Controller\AbstractController;
use Plugin\FreeeLight\Entity\FreeeAccountItem;
use Plugin\FreeeLight\Entity\FreeeCompany;
use Plugin\FreeeLight\Entity\FreeeLight;
use Plugin\FreeeLight\Entity\FreeeTax;
use Plugin\FreeeLight\Entity\FreeeOAuth2;
use Plugin\FreeeLight\Entity\FreeeWallet;
use Guzzle\Http\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OAuth2Controller extends AbstractController
{

    public function receive_authcode(Application $app, Request $request)
    {
        $code = $request->get('code');
        $app['session']->set('authorization_code', $code);

        $client = new Client('https://api.freee.co.jp');

        $FreeeLight = $app['eccube.plugin.repository.freeelight']->find(1);
        $params = array(
            'grant_type'    => 'authorization_code',
            'client_id'      => $FreeeLight->getClientId(),
            'client_secret'      => $FreeeLight->getClientSecret(),
            'code'         => $code,
            'redirect_uri' => $app->url('plugin_FreeeLight_oauth2_receive_authcode')
        );

        $tokens = $client->post('/oauth/token', array(), $params)->send()->json();
        $OAuth2 = $app['eccube.plugin.repository.freee_oauth2']->find(FreeeOAuth2::DEFAULT_ID);
        if (!is_object($OAuth2)) {
            $OAuth2 = new FreeeOAuth2();
            $OAuth2->setId(FreeeOAuth2::DEFAULT_ID);
            $OAuth2->setPropertiesFromArray($tokens);
            $OAuth2->setUpdateDate(new \DateTime());
            $app['orm.em']->persist($OAuth2);
        } else {
            $OAuth2->setPropertiesFromArray($tokens);
            $OAuth2->setUpdateDate(new \DateTime());
        }
        $app['orm.em']->flush($OAuth2);

        $client = new Client('https://api.freee.co.jp');
        $params = array();

        $master = array();
        $companies = $client->get('/api/1/companies.json',
                                  array(
                                      'Authorization' => 'Bearer '.$OAuth2->getAccessToken()
                                  ),
                                  $params)->send()->json();

        foreach ($companies['companies'] as $arrCompany) {
            $Company = $app['eccube.plugin.repository.freee_company']->find($arrCompany['id']);
            if (!is_object($Company)) {
                $Company = new FreeeCompany();
                $Company->setPropertiesFromArray($arrCompany);
                $app['orm.em']->persist($Company);
            } else {
                $Company->setPropertiesFromArray($arrCompany);
            }
            $app['orm.em']->flush($Company);
        }
        $taxes = $client->get('/api/1/taxes/codes.json?company_id=193715',
                              array(
                                  'Authorization' => 'Bearer '.$OAuth2->getAccessToken()
                              ),
                              $params)->send()->json();
        foreach ($taxes['taxes'] as $arrTax) {
            $Tax = $app['eccube.plugin.repository.freee_tax']->find($arrTax['code']);
            if (!is_object($Tax)) {
                $Tax = new FreeeTax();
                $Tax->setPropertiesFromArray($arrTax);
                $app['orm.em']->persist($Tax);
            } else {
                $Tax->setPropertiesFromArray($arrTax);
            }
            $app['orm.em']->flush($Tax);
        }

        $walletables = $client->get('/api/1/walletables.json?company_id=193715',
                                   array(
                                       'Authorization' => 'Bearer '.$OAuth2->getAccessToken()
                                   ),
                                   $params)->send()->json();

        foreach ($walletables['walletables'] as $arrWallet) {
            $Wallet = $app['eccube.plugin.repository.freee_wallet']->find($arrWallet['id']);
            if (!is_object($Wallet)) {
                $Wallet = new FreeeWallet();
                $Wallet->setPropertiesFromArray($arrWallet);
                $app['orm.em']->persist($Wallet);
            } else {
                $Tax->setPropertiesFromArray($arrWallet);
            }
            $app['orm.em']->flush($Wallet);
        }

        $account_items = $client->get('/api/1/account_items.json?company_id=193715',
                                      array(
                                          'Authorization' => 'Bearer '.$OAuth2->getAccessToken()
                                      ),
                                      $params)->send()->json();
        foreach ($account_items['account_items'] as $arrItem) {
            $AccountItem = $app['eccube.plugin.repository.freee_account_item']->find($arrItem['id']);
            if (!is_object($AccountItem)) {
                $AccountItem = new FreeeAccountItem();
                $AccountItem->setPropertiesFromArray($arrItem);
                $app['orm.em']->persist($AccountItem);
            } else {
                $AccountItem->setPropertiesFromArray($arrItem);
            }
            $app['orm.em']->flush($AccountItem);
        }

        return $app->redirect($app->url('plugin_FreeeLight_config'));
    }
}

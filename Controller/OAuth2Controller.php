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

        return $app->redirect($app->url('plugin_FreeeLight_config_step3'));
    }
}

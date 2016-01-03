<?php

namespace Plugin\FreeeLight\Controller;

use Eccube\Application;
use Eccube\Controller\AbstractController;
use Plugin\FreeeLight\Entity\FreeeLight;
use Plugin\FreeeLight\Entity\FreeeAccountItem;
use Plugin\FreeeLight\Entity\FreeeCompany;
use Plugin\FreeeLight\Entity\FreeeTax;
use Plugin\FreeeLight\Entity\FreeeOAuth2;
use Plugin\FreeeLight\Entity\FreeeWallet;
use Guzzle\Http\Client;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ConfigController extends AbstractController
{
    public function index(Application $app, Request $request)
    {
        $FreeeLight = $app['eccube.plugin.repository.freeelight']->find(1);
        if (!is_object($FreeeLight)) {
            $FreeeLight = new FreeeLight();
        }
        $form = $app['form.factory']->createBuilder('freeelight_config', $FreeeLight)->getForm();

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $FreeeLight = $form->getData();
                $FreeeLight->setId(1);
                $app['orm.em']->persist($FreeeLight);
                $app['orm.em']->flush();
                return $app->redirect($app->url('plugin_FreeeLight_config_step2'));
            }
        }
        return $app->render('FreeeLight/Resource/template/admin/config.twig', array(
            'form' => $form->createView(),
            'Freee' => $FreeeLight,
            'redirect_uri' => $app->url('plugin_FreeeLight_oauth2_receive_authcode')
        ));
    }

    public function step2(Application $app)
    {
        $FreeeLight = $app['eccube.plugin.repository.freeelight']->find(1);
        if (!is_object($FreeeLight)) {
            $FreeeLight = new FreeeLight();
        }

        return $app->render('FreeeLight/Resource/template/admin/config_step2.twig', array(
            'Freee' => $FreeeLight,
            'redirect_uri' => $app->url('plugin_FreeeLight_oauth2_receive_authcode')
        ));
    }

    public function step3(Application $app, Request $request)
    {
        $FreeeLight = $app['eccube.plugin.repository.freeelight']->find(1);
        if (!is_object($FreeeLight)) {
            $FreeeLight = new FreeeLight();
        }
        $form = $app['form.factory']->createBuilder('freeelight_config2', $FreeeLight)->getForm();

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $FreeeCompany = $form->getData();

                $FreeeLight->setCompanyId($FreeeCompany->getCompanyId()->getId()); // TODO リレーションにする
                $app['orm.em']->flush();

                $OAuth2 = $app['eccube.plugin.repository.freee_oauth2']->find(FreeeOAuth2::DEFAULT_ID);
                $params = array();
                $client = new Client('https://api.freee.co.jp');

                if ($OAuth2->isExpire()) {
                    $params = array(
                        'grant_type'    => 'refresh_token',
                        'client_id'      => $FreeeLight->getClientId(),
                        'client_secret'      => $FreeeLight->getClientSecret(),
                        'refresh_token'         => $OAuth2->getRefreshToken(),
                    );

                    $data = $client->post('/oauth/token?grant_type=refresh_token', array(), $params)->send()->json();
                    $OAuth2->setPropertiesFromArray($data);
                    $app['orm.em']->flush();
                } else {
                    $app['session']->set('access_token', 'not expire');
                }

                $taxes = $client->get('/api/1/taxes/codes.json?company_id='.$FreeeLight->getCompanyId(),
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

                $walletables = $client->get('/api/1/walletables.json?company_id='.$FreeeLight->getCompanyId(),
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

                $account_items = $client->get('/api/1/account_items.json?company_id='.$FreeeLight->getCompanyId(),
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

                return $app->redirect($app->url('plugin_FreeeLight_config_complete'));
            }
        }

        return $app->render('FreeeLight/Resource/template/admin/config_step3.twig', array(
            'form' => $form->createView(),
            'Freee' => $FreeeLight,
            'redirect_uri' => $app->url('plugin_FreeeLight_oauth2_receive_authcode')
        ));
    }

    public function complete(Application $app)
    {
        return $app->render('FreeeLight/Resource/template/admin/config_complete.twig');
    }
}

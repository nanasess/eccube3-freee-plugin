<?php
namespace Plugin\FreeeLight\ServiceProvider;

use Eccube\Application;
use Silex\Application as BaseApplication;
use Silex\ServiceProviderInterface;
use Plugin\FreeeLight\Form\Type;
use Freee\Email;
use Freee;

class FreeeLightServiceProvider implements ServiceProviderInterface
{
    public function register(BaseApplication $app)
    {
        $app->match(
            '/'.$app['config']['admin_route'].'/plugin/FreeeLight/config',
            'Plugin\FreeeLight\Controller\ConfigController::index')
            ->bind('plugin_FreeeLight_config');
        $app->match(
            '/'.$app['config']['admin_route'].'/plugin/FreeeLight/config_complete',
            'Plugin\FreeeLight\Controller\ConfigController::complete')
            ->bind('plugin_FreeeLight_config_complete');
        $app->match(
            '/oauth2/receive_authcode',
            'Plugin\FreeeLight\Controller\OAuth2Controller::receive_authcode')
            ->bind('plugin_FreeeLight_oauth2_receive_authcode');

        // Form
        $app['form.types'] = $app->share($app->extend('form.types', function ($types) use ($app) {
            $types[] = new \Plugin\FreeeLight\Form\Type\FreeeLightConfigType($app);
            return $types;
        }));

        // Repository
        $app['eccube.plugin.repository.freeelight'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\FreeeLight\Entity\FreeeLight');
        });
        $app['eccube.plugin.repository.freee_oauth2'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\FreeeLight\Entity\FreeeOAuth2');
        });
        $app['eccube.plugin.repository.freee_tax'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\FreeeLight\Entity\FreeeTax');
        });
        $app['eccube.plugin.repository.freee_account_item'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\FreeeLight\Entity\FreeeAccountItem');
        });
        $app['eccube.plugin.repository.freee_wallet'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\FreeeLight\Entity\FreeeWallet');
        });
        $app['eccube.plugin.repository.freee_company'] = $app->share(function () use ($app) {
            return $app['orm.em']->getRepository('Plugin\FreeeLight\Entity\FreeeCompany');
        });
    }
    public function boot(BaseApplication $app)
    {
    }
}

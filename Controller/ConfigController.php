<?php

namespace Plugin\FreeeLight\Controller;

use Eccube\Application;
use Eccube\Controller\AbstractController;
use Plugin\FreeeLight\Entity\FreeeLight;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ConfigController extends AbstractController
{
    public function index(Application $app, Request $request)
    {
        $FreeeLight = $app['eccube.plugin.repository.sendgridlight']->find(1);
        if (!is_object($FreeeLight)) {
            $FreeeLight = new FreeeLight();
        }
        $form = $app['form.factory']->createBuilder('sendgridlight_config', $FreeeLight)->getForm();

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {

                $FreeeLight = $form->getData();
                $FreeeLight->setId(1);
                $app['orm.em']->persist($FreeeLight);
                $app['orm.em']->flush();
                return $app->redirect($app->url('plugin_FreeeLight_config_complete'));
            }
        }
        return $app->render('FreeeLight/Resource/template/admin/config.twig', array(
            'form' => $form->createView(),
            'Freee' => $FreeeLight,
        ));
    }

    public function complete(Application $app)
    {
        return $app->render('FreeeLight/Resource/template/admin/config_complete.twig');
    }
}

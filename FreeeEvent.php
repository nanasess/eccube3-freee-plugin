namespace Plugin\FreeeLight;

use Monolog\Logger;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Guzzle\Http\Client;
use Plugin\FreeeLight\Entity\FreeeLight;
use Plugin\FreeeLight\Entity\FreeeOAuth2;

class FreeeEvent
{

    /** @var  \Eccube\Application $app */
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function onRenderShoppingComplete(FilterResponseEvent $event)
    {

        $app = $this->app;
        $response = $event->getResponse();
        $event->setResponse($response);

        $orderId = $app['session']->get('eccube.front.shopping.order.id');
        $Order = $app['eccube.repository.order']->find($orderId);
        if (!$Order) {
            $app->log('onRenderShoppingComplete event Order not found', array(), Logger::ERROR);
            return;
        }

        $FreeeLight = $app['eccube.plugin.repository.freeelight']->find(1);
        if (!$FreeeLight && !$FreeeLight->getCompanyId()) {
            $app->log('onRenderShoppingComplete event Freee not setup', array(), Logger::ERROR);
            return;
        }

        $OAuth2 = $app['eccube.plugin.repository.freee_oauth2']->find(FreeeOAuth2::DEFAULT_ID);
        if (!$OAuth2) {
            $app->log('onRenderShoppingComplete event Freee OAuth2 unauthorization', array(), Logger::ERROR);
            return;
        }

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
        $AccountItem = $app['eccube.plugin.repository.freee_account_item']->findOneBy(
            array(
                'name' => '売掛金'
            )
        );
        $Tax = $app['eccube.plugin.repository.freee_tax']->findOneBy(
            array(
                'name' => 'sales_with_tax_8'
            )
        );
        $Wallet = $app['eccube.plugin.repository.freee_wallet']->findOneBy(
            array(
                'name' => '現金'
            )
        );

        $client = new Client('https://api.freee.co.jp');
        $detail = new \StdClass();
        $detail->account_item_id = $AccountItem->getId();
        $detail->tax_code = $Tax->getCode();
        $detail->amount = $Order->getPaymentTotal();
        $detail->item_id = null;
        $detail->section_id = null;
        $detail->tag_ids = array();
        $detail->description = "";

        $payment = new \StdClass();
        $payment->date = date('Y-m-d');
        $payment->from_walletable_type = $Wallet->getType();
        $payment->from_walletable_id = $Wallet->getId();
        $payment->amount = $Order->getPaymentTotal();

        $params = array(
            "company_id" => $FreeeLight->getCompanyId(),
            "issue_date" => date('Y-m-d'),
            "due_date" => null,
            "type" => "income",
            "partner_id" => null,
            "ref_number" => $Order->getId(),
            "details" => array($detail),
            // "payments" => array($payment)
            "payments" => array()
        );

        $app['session']->set('complete_params', json_encode($params));
        try {
            $request = $client->post('/api/1/deals.json',
                                     array(
                                         'Authorization' => 'Bearer '.$OAuth2->getAccessToken(),
                                         'content-type' => 'application/json'
                                     ),
                                     array());
            $request->setBody(json_encode($params));
            $result = $request->send()->json();

            $app['session']->set('complete', $result);
        } catch (\Exception $e) {
            $app->log($e->getMessage(), array(), Logger::ERROR);
        }
    }
}

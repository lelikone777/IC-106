<?php 

require_once __DIR__ . '/../../../landstat/vendor/autoload.php';
require_once __DIR__ . '/../../../_helpers/vendor/autoload.php';
require_once __DIR__ . '/Config.php';
require_once __DIR__ . '/Validator.php';

use Stat\App\Controllers\StatController;
use Service_landing\Helpers\Http;

class Phone 
{

    /**
     * @var string
     */
    private const LOG_FOLDER = __DIR__ . '/logs';


    /**
     * @var string
     */
    private const EXTRA_INIT_URL = 'http://inspigate.com/ksg/saudi_arabia/init/extra';


    /**
     * @var string
     */
    public $landingUrl;


    /**
     * @var string
     */
    public $sub_land;


    /**
     * @var string
     */
    public $wb_id;


    /**
     * @var string
     */
    public $fake_wb_id;


    /**
     * @var string
     */
    public $phone;


    /**
     * @var string
     */
    public $operator;


    /**
     * @return void
     */
    public function newAbonent(): void
    {
        // StatController::newAbonent($this->landingUrl, Config::serviceId($this->sub_land), $this->fake_wb_id);
    }



    /**
     * @return void
     * @throws Exception
     */
    public function submit(): void
    {
        try {
            // StatController::savePhone($this->fake_wb_id, $this->phone);
            $this->phone = Validator::phoneValidate($this->phone);

            if (!$this->wb_id) {
                $this->wb_id = $this->pumaInit();
            }

            $data = $this->extraInit();

            // StatController::phoneError($this->fake_wb_id, false);

            Http::redirect('pin.php', [
                'sub_land' => $this->sub_land,
                'wb_id' => $this->wb_id,
                // 'fake_wb_id' => $this->fake_wb_id,
                'phone' => $this->phone,
                'operator' => $this->operator,
                'successUrl' => $data['successUrl'],
                'failUrl' => $data['failUrl'],
            ], self::LOG_FOLDER);

        } catch (Exception $e) {
            // StatController::phoneError($this->fake_wb_id, true, $e->getMessage());
            throw $e;
        }
    }


    /**
     * @return string
     * @throws Exception
     */
    public function pumaInit(): string 
    {
        $data = Http::pumaInit('host=aeke.planet-games.today&country=ae&operator=ksg_etisalat', self::LOG_FOLDER);

        $wb_id = $data['wb_subscription_id'] ?? '';
        
        if (!$wb_id) {
            throw new Exception($data['reason'] ?? 'Init error occurred');
        }

        return $wb_id;
    }

    
    /**
     * @return array
     * @throws Exception
     */
    private function extraInit(): array 
    {
        $response = Http::post(self::EXTRA_INIT_URL, [
            'msisdn' => $this->phone,
            'subscription_id' => $this->wb_id,
            'countryId' => '247',
            'operatorId' => '28',
        ], self::LOG_FOLDER);

        $data = json_decode($response->body, true);

        if ($data['status'] === 'success') {

            if (isset($data['message']) && $data['message'] === 'Subscription already exists') {
                Http::redirect('https://aeke.planet-games.today/', [
                    'status' => 'already_subscribed',
                    'wb_subscription_id' => $data['subscription_id'],
                ], self::LOG_FOLDER);
            }


            return [
                'successUrl' => $data['successUrl'],
                'failUrl' => $data['failUrl'],
            ];
        }

        throw new Exception($data['errorDesc'] ?? 'Extra init error occurred');
    }
}
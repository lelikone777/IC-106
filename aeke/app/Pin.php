<?php 

require_once __DIR__ . '/../../../landstat/vendor/autoload.php';
require_once __DIR__ . '/../../../_helpers/vendor/autoload.php';
require_once __DIR__ . '/Validator.php';

use Service_landing\Helpers\Http;
use Service_landing\Helpers\Puma as P;
use Stat\App\Controllers\StatController;

class Pin 
{

    /**
     * @var string
     */
    private const LOG_FOLDER = __DIR__ . '/logs';


    /**
     * @var string
     */
    private const PIN_SUBMIT_URL = 'http://inspigate.com/ksg/saudi_arabia/pin_submit';


    /**
     * @var object
     */
    public $redis;

    
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
    public $pincode;


    /**
     * @var string
     */
    public $successUrl;


    /**
     * @var string
     */
    public $failUrl;



    public function __construct()
    {
        $this->redis = P::getRedis();
    }
    

    /**
     * @return void
     * @throws Exception
     */
    public function submit(): void
    {
        try {
            // StatController::savePin($this->fake_wb_id, $this->pincode);

            $this->pincode = Validator::pinValidate($this->pincode, $this->operator);

            $response = Http::post(self::PIN_SUBMIT_URL, [
                'pin' => $this->pincode,
                'msisdn' => $this->phone,
                'wb_id' => $this->wb_id,
            ], self::LOG_FOLDER);
    
            $data = json_decode($response->body, true);
    
            if ($data['status'] === 'success') {
    
                $this->redis->set("sakSubscribeBlock$this->phone", '');
                $this->redis->expire("sakSubscribeBlock$this->phone", 3600*12);
                
                // StatController::pinError($this->fake_wb_id, false);
                // StatController::subscribe($this->fake_wb_id);
                
                Http::redirect($this->successUrl, [], self::LOG_FOLDER);
            }
    
            throw new Exception($data['errorDesc'] ?? 'Pin submit error occurred');

        } catch (Exception $e) {
            // StatController::pinError($this->fake_wb_id, $e->getMessage());
            throw $e;
        }
    }
}
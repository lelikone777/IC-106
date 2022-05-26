<?php 
require_once __DIR__ . '/../../../_helpers/vendor/autoload.php';
require_once __DIR__ . '/Config.php';

use Service_landing\Helpers\Http;

class Validator 
{

    /**
     * @var string
     */
    private const LOG_FOLDER = __DIR__ . '/logs';

    /**
     * @param string $phone
     * @return string
     * @throws Exception
     */
    public static function phoneValidate(string $phone): string
    {
        $code = '971';
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (substr($phone, 0, 1) === '0') {
            $phone = substr_replace($phone, '', 0, 1);
        } else if (substr($phone, 0, strlen($code)) === $code) {
            $phone = substr_replace($phone, '', 0, strlen($code));
        }

        $phone = "$code$phone";

        if (substr($phone, 0, strlen($code . '5')) === $code . '5' && strlen($phone) === 12) {
            return $phone;
        }

        throw new Exception("Check your number and try again");
    }


    /**
     * @param string $pin
     * @param string $operator
     * @return string
     */
    public static function pinValidate(string $pin, string $operator): string 
    {
        $pin = preg_replace('/[^0-9]/', '', $pin);

        if (in_array($operator, ['zain', 'mobily']) && strlen($pin) === 6) {
            return $pin;

        }

        if (strlen($pin) === 4) {
            return $pin;
            
        }

        throw new Exception("Invalid PIN");
    }



    /**
     * @param string $phone
     * @return string
     * @throws Exception
     */
    public static function determineOperator(string $phone): string 
    {
        $code = substr($phone, 3, 2);

        foreach (Config::OPERATORS as $operator => $settings) {
            if (in_array($code, $settings['defCodes'])) {
                return $operator;
            }
        }

        throw new Exception("Operator hasn't been determined");
    }


    /**
     * @param string $phone
     * @param string $land
     * @param string $landName
     * @return string
     * @throws Exception
     */
    public static function determineOperatorByHlrlookup(string $phone): string 
    {
        $response = Http::get('https://hlrlookup.com/api/hlr/', [
            'apikey' => 'CWKusxXvZdmqlmZkh1SrGUvx6agKKCCG',
            'password' => '7Pu2xKG9zfG.qH@',
            'msisdn' => $phone,
        ], self::LOG_FOLDER);

        $data = @json_decode($response->body, true);
        $operatorInfo = $data['issueing_info'] ?? '';

        if ($operatorInfo && isset($operatorInfo['network_name'])) {
            
            foreach (Config::operators() as $operator) {
                if (substr_count(strtolower($operatorInfo['network_name']), strtolower($operator))) {
                    return $operator;
                }
            }

            throw new Exception("Unsupported operator");

        }

        return '';
    }
}
<?php 

require_once __DIR__ . '/../../_helpers/vendor/autoload.php';
require_once __DIR__ . '/../../landstat/vendor/autoload.php';
require_once __DIR__ . '/app/Phone.php';
require_once __DIR__ . '/app/View.php';
require_once __DIR__ . '/app/Config.php';

use Service_landing\Helpers\Url;
use Service_landing\Helpers\Http;
use Service_landing\Helpers\Log;
use Stat\App\Controllers\StatController;

header("Content-Security-Policy: default-src * 'unsafe-inline' 'unsafe-eval'");
header("X-Frame-Options: SAMEORIGIN");
header('X-Content-Type-Options: nosniff');
header("Referrer-Policy: no-referrer");
header("Permissions-Policy: microphone=()");

const LOG_FOLDER = __DIR__ . '/app/logs';

$error = '';

$phone = new Phone();
$phone->landingUrl = preg_replace('/\?.*/', '', Url::currentUri());
$phone->sub_land = $_GET['sub_land'] ?? 'main';
$phone->wb_id = $_GET['ext_id'] ?? '';
// $phone->fake_wb_id = $_GET['fake_wb_id'] ?? '';

// if (!$phone->fake_wb_id) {
//     Http::redirect(Url::currentUri(), ['fake_wb_id' => StatController::getFakeSubscriptionId()]);
// }

// $phone->newAbonent();

// $abonent = StatController::getAbonent($phone->fake_wb_id);

// if ((int) $abonent['service_id'] !== Config::serviceId($phone->sub_land)) {
//     Http::redirect(str_replace("fake_wb_id=$phone->fake_wb_id", "fake_wb_id=" . StatController::getFakeSubscriptionId(), Url::currentUri()));
// }

if (isset($_POST['phone']) && !$error) {
    try {
        $phone->phone = $_POST['phone'];
        $phone->operator = $_POST['operator'] ?? '';
        $phone->submit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}


if ($error) {
    Log::errorLog(LOG_FOLDER, "wb_id=$phone->wb_id, phone=$phone->phone, operator=$phone->operator, sub_land=$phone->sub_land, error_description=$error");
}


// View
$view = new View();
$view->sub_land = $phone->sub_land;
echo $view->render('index', $error);
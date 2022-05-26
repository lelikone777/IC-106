<?php 

require_once __DIR__ . '/../../_helpers/vendor/autoload.php';
require_once __DIR__ . '/app/Pin.php';
require_once __DIR__ . '/app/View.php';

use Service_landing\Helpers\Filter;
use Service_landing\Helpers\Http;
use Service_landing\Helpers\Log;

const LOG_FOLDER = __DIR__ . '/app/logs';

$error = '';

if (!Filter::notEmptyParameters($_GET, ['wb_id', 'phone', 'successUrl', 'failUrl'])) {
    Http::redirect('https://www.google.com/');
}

$pin = new Pin();
$pin->sub_land = $_GET['sub_land'];
$pin->wb_id = $_GET['wb_id'];
// $pin->fake_wb_id = $_GET['fake_wb_id'];
$pin->phone = $_GET['phone'];
$pin->operator = $_GET['operator'];
$pin->successUrl = $_GET['successUrl'];
$pin->failUrl = $_GET['failUrl'];

if ($pin->redis->exists("sakSubscribeBlock$app->phone")) {
    Http::redirect('https://www.google.com/', ['wb_id' => $app->wb_id], LOG_FOLDER);
}


if (isset($_POST['pin'])) {
    $pin->pincode = $_POST['pin'];

    try {
        $pin->submit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}


if ($error) {
    Log::errorLog(LOG_FOLDER, "wb_id=$pin->wb_id, phone=$pin->phone, pin=$pin->pincode operator=$pin->operator, sub_land=$pin->sub_land, error_description=$error");
}


// View
$view = new View();
$view->sub_land = $pin->sub_land;
echo $view->render('pin', $error);
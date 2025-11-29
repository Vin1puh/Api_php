<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../objects/Worker.php';

$database = new Database();
$db = $database->getConnection();
$worker = new Worker($db);

$data = json_decode(file_get_contents("php://input"));

$result = array();

if (
    !empty($data->assembly_date) &&
    !empty($data->worker_name) &&
    !empty($data->product_code) &&
    !empty($data->product_name) &&
    !empty($data->quantity) &&
    !empty($data->work_cost)
) {
    $success = $worker->createAssembly(
        $data->assembly_date,
        $data->worker_name,
        $data->product_code,
        $data->product_name,
        $data->quantity,
        $data->work_cost
    );

    if ($success) {
        http_response_code(201);
        $result["message"] = "Запись о сборке создана успешно.";
        $result["success"] = true;
    } else {
        http_response_code(503);
        $result["message"] = "Не удалось создать запись о сборке.";
        $result["success"] = false;
    }
} else {
    http_response_code(400);
    $result["message"] = "Неполные данные. Не удалось создать запись о сборке.";
    $result["success"] = false;
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);
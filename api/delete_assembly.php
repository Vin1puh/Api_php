<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.php';
include_once '../objects/Worker.php';

$database = new Database();
$db = $database->getConnection();
$worker = new Worker($db);

$data = json_decode(file_get_contents("php://input"));

$result = array();

if (!empty($data->id)) {
    $success = $worker->deleteAssembly($data->id);

    if ($success) {
        http_response_code(200);
        $result["message"] = "Запись о сборке удалена успешно.";
        $result["success"] = true;
    } else {
        http_response_code(503);
        $result["message"] = "Не удалось удалить запись о сборке.";
        $result["success"] = false;
    }
} else {
    http_response_code(400);
    $result["message"] = "Не указан ID записи для удаления.";
    $result["success"] = false;
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);
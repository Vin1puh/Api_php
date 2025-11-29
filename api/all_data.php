<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../objects/Worker.php';

$database = new Database();
$db = $database->getConnection();
$worker = new Worker($db);

$result = array();

$allData = $worker->getAllData();
$result['all_data'] = array();
while ($row = $allData->fetch(PDO::FETCH_ASSOC)) {
    array_push($result['all_data'], $row);
}

http_response_code(200);
echo json_encode($result, JSON_UNESCAPED_UNICODE);
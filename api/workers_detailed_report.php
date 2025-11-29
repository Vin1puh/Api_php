<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../objects/Worker.php';

$database = new Database();
$db = $database->getConnection();
$worker = new Worker($db);

$result = array();

$detailedReport = $worker->getWorkersDetailedReport();
$result['workers_detailed_report'] = array();
while ($row = $detailedReport->fetch(PDO::FETCH_ASSOC)) {
    array_push($result['workers_detailed_report'], $row);
}

http_response_code(200);
echo json_encode($result, JSON_UNESCAPED_UNICODE);
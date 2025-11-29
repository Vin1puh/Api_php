<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../objects/Worker.php';

$database = new Database();
$db = $database->getConnection();
$worker = new Worker($db);

$result = array();

// Сводная информация
$topWorker = $worker->getTopWorker();
$result['top_worker'] = $topWorker;

if ($topWorker) {
    $bestDay = $worker->getBestDay($topWorker['worker_name']);
    $result['best_day'] = $bestDay;
}

$worstWorker = $worker->getWorstWorker();
$result['worst_worker'] = $worstWorker;

http_response_code(200);
echo json_encode($result, JSON_UNESCAPED_UNICODE);
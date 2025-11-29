<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/Database.php';
include_once '../objects/Worker.php';

$database = new Database();
$db = $database->getConnection();
$worker = new Worker($db);

$result = array();

// Все данные (оригинальный функционал)
$topWorker = $worker->getTopWorker();
$result['top_worker'] = $topWorker;

if ($topWorker) {
    $bestDay = $worker->getBestDay($topWorker['worker_name']);
    $result['best_day'] = $bestDay;
}

$earnings = $worker->getMonthlyEarnings();
$result['monthly_earnings'] = array();
while ($row = $earnings->fetch(PDO::FETCH_ASSOC)) {
    array_push($result['monthly_earnings'], $row);
}

$worstWorker = $worker->getWorstWorker();
$result['worst_worker'] = $worstWorker;

$report = $worker->getWorkersReport();
$result['workers_report'] = array();
while ($row = $report->fetch(PDO::FETCH_ASSOC)) {
    array_push($result['workers_report'], $row);
}

$detailedReport = $worker->getWorkersDetailedReport();
$result['workers_detailed_report'] = array();
while ($row = $detailedReport->fetch(PDO::FETCH_ASSOC)) {
    array_push($result['workers_detailed_report'], $row);
}

$allData = $worker->getAllData();
$result['all_data'] = array();
while ($row = $allData->fetch(PDO::FETCH_ASSOC)) {
    array_push($result['all_data'], $row);
}

http_response_code(200);
echo json_encode($result, JSON_UNESCAPED_UNICODE);
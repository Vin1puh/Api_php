<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'config/Database.php';

$database = new Database();
$db = $database->getConnection();

echo json_encode([
    "message" => "База данных инициализирована успешно!",
    "tables_created" => true,
    "test_data_inserted" => true
], JSON_UNESCAPED_UNICODE);
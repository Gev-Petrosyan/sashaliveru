<?php

// Content-Type запроса делаем json
header('Content-Type: application/json; charset=utf-8');

// Валидация данных запроса
if (empty($_POST["month"]) || empty($_POST["year"]))
    exit;

$month = $_POST["month"];
$year = $_POST["year"];

require_once("../database/connect.php");

// SQL запрос, берем турницы по month, year
$data = $conn->query("SELECT id, from_date, to_date, title, classes 
FROM `tournaments` 
WHERE IF (to_date IS NOT NULL, (MONTH(from_date) <= '{$month}') AND (MONTH(to_date) >= '{$month}')
AND (YEAR(from_date) <= {$year}) AND (YEAR(to_date) >= {$year}),
MONTH(from_date) = '{$month}' AND YEAR(from_date) = {$year}) ORDER BY from_date DESC");

// Если пусто то 204
if (empty($data))
    http_response_code(204);

$response = array();
while($row = $data->fetch_assoc())
    array_push($response, $row);

// Даем данные фронту
echo json_encode($response);

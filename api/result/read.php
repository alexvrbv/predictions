<?php

// Необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

// Подключение файла для соединения с базой и файл с объектом 
include_once '../config/Core.php';
include_once '../config/Database.php';
include_once '../objects/Result.php';

// Соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// Подготовка объекта 
$result = new Result($db);
$result->query = isset($_GET['query']) ? $_GET['query'] : die();
$result->api_key = API_KEY;

//Получение подсказок
$result->getPredictions();

//Сохранение запроса и результата в базе
$result->saveResultToDb();
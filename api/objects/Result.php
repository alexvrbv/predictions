<?php

class Result {

    // Подключение к базе данных и таблице 'results'
    private $conn;
    private $table_name = "results";

    // Свойства объекта
    public $api_key;
    public $query;
    public $response;

    // конструктор для соединения с базой данных
    public function __construct($db){
        $this->conn = $db;
    }

    // Метод для получения подсказок (Google Maps API отдает максимум 5)
    function getPredictions() {

        $api_key = $this->api_key;
        $query = $this->query;
        if (isset($_REQUEST['query'])) {
            $query = $_REQUEST['query'];
        }

        $url = 'https://maps.googleapis.com/maps/api/place/queryautocomplete/json'
            .'?key='.API_KEY
            .'&types=(cities)'
            .'&components=country:ru'
            .'&input='.urlencode($query);

        $this->response = file_get_contents($url);
        echo $this->response;

    }

    // Логируем в базу запрос и результат
    function saveResultToDb() {

        // Запрос для вставки (создания) записей 
        $dbQuery = "INSERT INTO
                    " . $this->table_name . "
                SET
                    query=:query, response=:response";

        // Подготовка запроса 
        $stmt = $this->conn->prepare($dbQuery);

        // Очистка 
        $this->query=htmlspecialchars(strip_tags($this->query));

        // Привязка значений 
        $stmt->bindParam(":query", $this->query);
        $stmt->bindParam(":response", $this->response);

        // Выполняем запрос
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
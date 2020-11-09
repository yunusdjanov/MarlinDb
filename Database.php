<?php

class Database {
    private static $instance = null;
    private $pdo , $query , $error = false , $results , $count;

    //Подключение к базе данных

    private function __construct() {
        try{
            $this->pdo = new PDO('mysql:host=localhost;dbname=dbname', 'username', 'password');

        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }

    //Проверка на инициализацию объекта PDO и инициализация самого объекта PDO

    public static function getInstance() {
        if(!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    //Выполнение всех запросов в бд

    public function query($sql , $params = []) {

        $this->error = false;
        $this->query = $this->pdo->prepare($sql);


        if (count($params)) {
            $i = 1;
            foreach ($params as $param) {
                $this->query->bindValue($i , $param);
                $i++;
            }
        }


        if (!$this->query->execute()) {
            $this->error = true;
        }else{
            $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
            $this->count = $this->query->rowCount();
        }


        return $this;

    }


    //Подготовка SQL запроса для выполнения и вывода всех данных результата SQL запроса
    public function get($table , $where = []) {
        return $this->action('SELECT *', $table , $where);
    }


    //Подготовка и выполниние SQL запроса для удаления данных из базе данных по ID
    public function delete($table , $where = []) {
        return $this->action('DELETE', $table , $where);
    }

    public function action($action , $table , $where = []) {
        if(count($where) === 3) {

            $operators = ['=' , '>' , '<' , '>=' , '<='];

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if (in_array($operator , $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if (!$this->query($sql , [$value])->error()) {
                    return $this;
                }
            }
        }
        return false;
    }

    //Подготовка и выполниние SQL запроса для сохранения данных в бд
    public function insert($table , $fields = []) {
        $values = '';

        foreach ($fields as $field) {
            $values .= "?,";
        }
        $val = rtrim($values , ',');

        $sql = "INSERT INTO {$table} (". '`' . implode('`,`' , array_keys($fields)) . '`' . ") VALUES({$val})";

        if (!$this->query($sql , $fields)->error()) {
            return true;
        }
        return false;
    }

    //Подготовка и выполниние SQL запроса для обновления данных в базе данных по ID
    public function update($table, $id, $fields = [])
    {
        $set = '';
        foreach($fields as $key => $field) {
            $set .= "{$key} = ?,";
        }

        $set = rtrim($set, ',');

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if(!$this->query($sql, $fields)->error()){
            return true;
        }

        return false;
    }

    //Возвращает результат из выполненного SQL запроса.Метод используется после выполнения метода query().
    public function results() {
        return $this->results;
    }

    //Возвращает первый элемент из выполненного SQL запроса
    public function first() {
        return $this->results()[0];
    }

    //Возвращает ошибок
    public function error() {
        return $this->error;
    }

    //Возвращает количество элементов из выполненного SQL запроса
    public function count() {
        return $this->count;
    }


}

<?php

class Db
{
    private static $instance = null;

    private $connections = null;

    private static $host = DB_MYSQL_HOST;
    private static $dbname = DB_MYSQL_DBNAME;
    private static $username = DB_MYSQL_USERNAME;
    private static $password = DB_MYSQL_PASSWORD;


    private static function getInstance()
	{
        // インスタンスが存在していない場合は新規コネクション取得
		if (is_null(self::$instance)) {
			self::$instance = new Db();
			self::$instance->connect();
		}

		return self::$instance->connections;
	}


    // DBコネクション取得
    private function connect()
    {
        $host = self::$host;
        $dbname = self::$dbname;

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", self::$username, self::$password);

			// エラーモードを例外に設定
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// デフォルトのフェッチモードを配列に設定
			$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            $this->connections = $conn;
        } catch(PDOException $e) {
            // 例外再スロー
            throw $e;
        }
    }


    // 実行
    public static function execute($sql, $params = [])
	{
		try {
            $pdo = self::getInstance();

			$stmt = $pdo->prepare($sql);

            // $paramsが空の場合
            if (empty($params)) {
                $stmt->execute();
            } else {
                $stmt->execute($params);
            }

            return $stmt;
		} catch (PDOException $e) {
            throw $e;
		}
	}


    // 結果を1行取得
    public static function fetch($sql, $params = [])
	{
		$buff = self::execute($sql, $params);
		return ($buff !== false) ? $buff->fetch(PDO::FETCH_ASSOC) : false;
	}


    // 結果を全件取得
    public static function fetchAll($sql, $params = [])
	{
		$buff = self::execute($sql, $params);
		return ($buff !== false) ? $buff->fetchAll(PDO::FETCH_ASSOC) : false;
	}


    // インサート
    public static function create($table , $fields = [])
    {
        $colms = implode(',' , array_keys($fields));
        $values = ':' . implode(', :' , array_keys($fields));
        $sql = "INSERT INTO {$table} ({$colms}) VALUES ({$values})";

        try {
            $pdo = self::getInstance();

            $stmt = $pdo->prepare($sql);

            foreach($fields as $key => $data) {
                $stmt->bindValue(':'. $key , $data );
            }

            $stmt->execute();

            return $pdo->lastInsertId();
        } catch (\PDOException $e) {
            throw $e;
        }
    }
}
<?php
// ドライバ呼び出しを使用して MySQL データベースに接続します
$dsn = 'mysql:dbname=test;host=mysql5.7';
$user = 'test';
$password = 'test';

try {
    $dbh = new PDO($dsn, $user, $password);
    echo "接続成功\n";
} catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}

// require_once()
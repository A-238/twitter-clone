<?php

session_start();

// 環境ごとに切り替える
define('ENV_MODE' , 'development');
// define('ENV_MODE' , 'production');

// 環境ごとの値
switch (ENV_MODE) {
    // 本番環境
    case 'production':
        // ベースURL
        define('BASE_URL' , 'https://xrecruit3072.xsrv.jp/source');

        // DB接続情報
        define('DB_MYSQL_HOST' , 'mysql3008.xserver.jp');
        define('DB_MYSQL_DBNAME' , 'xrecruit3072_recruit');
        define('DB_MYSQL_USERNAME' , 'xrecruit3072_7l6');
        define('DB_MYSQL_PASSWORD' , '1a1xlorypk');
        break;

    // 開発環境
    case 'development':
        define('BASE_URL' , 'http://localhost:8080');

        define('DB_MYSQL_HOST' , 'mysql5.7');
        define('DB_MYSQL_DBNAME' , 'test');
        define('DB_MYSQL_USERNAME' , 'test');
        define('DB_MYSQL_PASSWORD' , 'test');
        break;
}

// CORE
require_once('./core/Db.php');
require_once('./core/Request.php');

// Classes
require_once('./classes/Common.php');
require_once('./classes/Validate.php');

// Models
require_once('./models/User.php');
require_once('./models/Post.php');
require_once('./models/Relationship.php');
require_once('./models/Like.php');
require_once('./models/Comment.php');

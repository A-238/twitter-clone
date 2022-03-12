<?php
// 新規ユーザー登録ページ
require_once('./init.php');

// ログイン状態の場合はホームへ遷移
if (Common::isLogin()) {
    header('Location: ' . BASE_URL . '/home.php');
}

$err = [];

$csrfToken = Request::isPost() ? $_SESSION['csrf_token'] : Common::createCsrfToken();

if (Request::isPost()) {

    $postParam = [
        'name' => Request::post('name', ''),
        'email' => Request::post('email', ''),
        'password' => Request::post('password', ''),
        'csrf_token' => Request::post('csrf_token', '')
    ];

    // バリデーション
    $err = User::validate($postParam, true);

    if (empty($err)) {
        $date = date("Y-m-d H:i:s");

        // DB保存
        $data = [
            'name' => $postParam['name'],
            'email' => $postParam['email'],
            'password' => password_hash($postParam['password'], PASSWORD_DEFAULT), // ハッシュ化して保存
            'created_at' => $date,
            'modified_at' => $date
        ];

        try {
            $insertId = Db::create('users', $data);

            // セッションへ格納し、ログイン状態とする
            $_SESSION['user_id'] = $insertId;
            $_SESSION['flash_message'] = 'ユーザー登録に成功しました';

            header('Location: ' . BASE_URL . '/home.php');
        } catch (\PDOException $e) {
            var_dump('Exception: ' . $e->getMessage());
        }
    }
}
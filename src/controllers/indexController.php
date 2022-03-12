<?php
// ログインページ
require_once('./init.php');

// ログイン状態の場合はホームへ遷移
if (Common::isLogin()) {
    header('Location: ' . BASE_URL . '/home.php');
}

$err = [];

$csrfToken = Request::isPost() ? $_SESSION['csrf_token'] : Common::createCsrfToken();

if (Request::isPost()) {

    $postParam = [
        'email' => Request::post('email', ''),
        'password' => Request::post('password', ''),
        'csrf_token' => Request::post('csrf_token', '')
    ];

    // バリデーション
    $err = User::validate($postParam, false);

    if (empty($err)) {
        try {
            $user = User::getData($postParam['email']);

            // 認証成功で遷移
            if (!empty($user)) {
                // パスワード認証
                if(password_verify($postParam['password'], $user['password'])) {
                    // セッションへ格納し、ログイン状態とする
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['flash_message'] = 'ログインしました';
                    header('Location: ' . BASE_URL . '/home.php');
                }
            }

            $err[] = 'メールアドレス、またはパスワードが間違っています';
        } catch (\PDOException $e) {
            var_dump('Exception: ' . $e->getMessage());
        }
    }
}
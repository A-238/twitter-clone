<?php
// ユーザーホームページ
require_once('./init.php');

Common::loginCheck();

// フラッシュメッセージ取得
$flashMsg = null;
if (isset($_SESSION['flash_message'])) {
    $flashMsg = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

$err = [];
$userId = $_SESSION['user_id'];

$csrfToken = Request::isPost() ? $_SESSION['csrf_token'] : Common::createCsrfToken();

if (Request::isPost()) {
    $postParam = [
        'user_id' => Request::post('user_id', ''),
        'content' => Request::post('content', ''),
        'csrf_token' => Request::post('csrf_token', '')
    ];

    // バリデーション
    $err = Post::validate($postParam);

    if (empty($err)) {
        $date = date("Y-m-d H:i:s");

        // DB保存
        $data = [
            'user_id' => $postParam['user_id'],
            'content' => $postParam['content'],
            'created_at' => $date,
            'modified_at' => $date
        ];

        try {
            Db::create('posts', $data);

            $_SESSION['flash_message'] = '投稿しました';
            header('Location: ' . BASE_URL . '/home.php');
        } catch (\PDOException $e) {
            var_dump('Exception: ' . $e->getMessage());
        }
    }
}

try {
    $posts = Post::getUserAndFollowUserData($userId);
    $user = User::getDataById($userId);
} catch (\PDOException $e) {
    var_dump('Exception: ' . $e->getMessage());
}

// 個別JS読み込み
$javaScript = [
    './assets/js/like.js',
    './assets/js/comment.js'
];
<?php
// ユーザー詳細ページ
require_once('./init.php');

Common::loginCheck();

// フラッシュメッセージ取得
$flashMsg = null;
if (isset($_SESSION['flash_message'])) {
    $flashMsg = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

$err = [];
$userId = Request::get('id');

$csrfToken = Request::isPost() ? $_SESSION['csrf_token'] : Common::createCsrfToken();

// 自分のページを表示している場合true
$isOwn = $_SESSION['user_id'] === $userId ? true : false;
// 自分（閲覧者）がフォローしているユーザーIDリスト（フォロー、アンフォローボタン表示判定のため）
$ownFollowList = [];

try {
    $user = User::getDataById($userId);

    if (!empty($user)) {
        $posts = Post::getOnlyUserData($userId, $_SESSION['user_id']);
        $ownFollowList = array_column(Relationship::getFollow($_SESSION['user_id']), 'follow_id');
    } else {
        $err[] = 'ユーザーが存在しません';
    }
} catch (\PDOException $e) {
    var_dump('Exception: ' . $e->getMessage());
}

// 個別JS読み込み
$javaScript = [
    './assets/js/follow.js',
    './assets/js/like.js',
    './assets/js/comment.js'
];
<?php
// 全ユーザー一覧ページ
require_once('./init.php');

Common::loginCheck();

$csrfToken = Request::isPost() ? $_SESSION['csrf_token'] : Common::createCsrfToken();

// 自分（閲覧者）がフォローしているユーザーIDリスト（フォロー、アンフォローボタン表示判定のため）
$ownFollowList = [];

try {
    $users = User::getAll();
    $ownFollowList = array_column(Relationship::getFollow($_SESSION['user_id']), 'follow_id');
} catch (\PDOException $e) {
    var_dump('Exception: ' . $e->getMessage());
}

// 個別JS読み込み
$javaScript = [
    './assets/js/follow.js'
];
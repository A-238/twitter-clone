<?php
// コメント投稿用（Ajax用）
require_once('./init.php');

// 明示的に指定しない場合は、text/html型と判断される
header("Content-type: application/json; charset=UTF-8");

// 返戻データ
$res = [
    'result' => 'ng'
];

// ログインチェック
if (!Common::isLogin()) {
    //JSONデータを出力
    echo json_encode($res);
    exit;
}

if (Request::isAjax()) {
    // 自分のユーザーID
    $userId = $_SESSION['user_id'];

    $postParam = [
        'user_id' => $userId, // セッションから取得
        'post_id' => Request::post('post_id', ''), // 対象投稿のID
        'content' => Request::post('content', ''),
        'csrf_token' => Request::post('csrf_token', ''),
    ];

    $err = Comment::validate($postParam);

    if (empty($err)) {
        $date = date("Y-m-d H:i:s");

        // DB保存
        $data = [
            'user_id' => $postParam['user_id'],
            'post_id' => $postParam['post_id'],
            'content' => $postParam['content'],
            'created_at' => $date,
            'modified_at' => $date,
        ];

        try {
            Db::create('comments', $data);
            $user = User::getDataById($_SESSION['user_id']);

            $res['result'] = 'ok';
            $res['user_id'] = $user['id'];
            $res['user_name'] = $user['name'];
            $res['post_id'] = $postParam['post_id'];
            $res['content'] = Common::h($postParam['content']);
            $res['created_at'] = $date;
        } catch (\PDOException $e) {
            $res['err'] = $e->getMessage();
        }
    } else {
        $res['err'] = $err;
    }
}

echo json_encode($res, JSON_UNESCAPED_UNICODE);
exit;